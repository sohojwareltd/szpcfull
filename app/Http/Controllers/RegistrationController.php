<?php

namespace App\Http\Controllers;

use App\Enums\ContestType;
use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Registration;
use App\Services\MessagingService;
use App\Services\TeamProvisioner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(
        private readonly MessagingService $messaging,
    ) {}

    public function create(): View
    {
        return view('register', [
            'contests' => ContestType::cases(),
            'seoPage' => 'register',
        ]);
    }

    public function success(): View|RedirectResponse
    {
        $reg = session('registration_success');

        if (! is_array($reg) || empty($reg['reference_code'])) {
            return redirect()->route('register');
        }

        return view('registration-success', [
            'reg' => $reg,
            'isIthq' => ($reg['contest_type'] ?? '') === ContestType::Ithq->value,
            'seoPage' => 'success',
        ]);
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $contest = ContestType::from($data['contest_type']);

        $registration = new Registration([
            'reference_code' => $this->uniqueReferenceCode(),
            'contest_type' => $contest,
            'team_name' => $data['team_name'] ?? null,
            'university' => $data['university'] ?? null,
            'institution_name' => $data['institution_name'] ?? null,
            'district' => $data['district'] ?? null,
            'category' => $data['category'] ?? null,
            'full_name' => $data['full_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $this->primaryPhone($contest, $data),
            'address' => $data['address'] ?? null,
        ]);
        $registration->save();

        $this->syncMembers($registration, $data);

        app(TeamProvisioner::class)->syncFromRegistration($registration->fresh(['members']));

        $registration = $registration->fresh(['members', 'team.members', 'team.leader']);
        $this->messaging->sendRegistrationSubmitted($registration);

        return redirect()
            ->route('register.success')
            ->with('registration_success', [
                'reference_code' => $registration->reference_code,
                'contest_type' => $registration->contest_type->value,
                'phone' => $registration->phone,
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function primaryPhone(ContestType $contest, array $data): string
    {
        return match ($contest) {
            ContestType::Ithq => $data['phone'],
            default => $data['member1_phone'],
        };
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncMembers(Registration $registration, array $data): void
    {
        if ($registration->contest_type === ContestType::Ithq) {
            return;
        }

        foreach ([1, 2, 3] as $index) {
            $name = $data["member{$index}_full_name"] ?? null;
            if (! $name) {
                continue;
            }

            $registration->members()->create([
                'sort_order' => $index,
                'full_name' => $name,
                'phone' => $index === 1 ? ($data['member1_phone'] ?? null) : null,
                'tshirt_size' => $data["member{$index}_tshirt"] ?? null,
            ]);
        }
    }

    private function uniqueReferenceCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Registration::where('reference_code', $code)->exists());

        return $code;
    }
}
