/* SZPC '26 — contest detail page renderer (vanilla JS, data-driven)
   Data source: official SZPC_2026_Proposal (3rd UGV SZPC & ICT Talent Hunt 2026) */

const SEGMENTS = {
  szpc: {
    accent: 'neon',
    kicker: 'University level contest',
    title: 'SZPC-2026',
    chips: ['3RD EDITION', 'ONLINE PRELIM + ONSITE FINAL', 'C / C++ / JAVA / PYTHON'],
    overview: 'The 3rd UGV South Zone Programming Contest — the flagship university battle. An online preliminary on 22 August filters the field; qualified teams meet onsite at UGV, Barishal on 29 August for a 3-hour, 9-problem final.',
    meta: [
      ['LEVEL', 'UNDERGRADUATE'],
      ['PRELIM', '22 AUG · ONLINE · 2H · 5 PROBLEMS'],
      ['FINAL', '29 AUG · ONSITE · 3H · 9 PROBLEMS'],
      ['FEE', '৳1,000 / TEAM'],
    ],
    eligibility: [
      'Undergraduate students of South Zone universities: UGV, Barishal University (BU), PSTU, GSTU, KUET, PUST, KU and other South Zone universities.',
      'Expected field: 30–35 teams from 5–6+ universities (150–165 students).',
      'A valid institutional ID card is mandatory at campus registration (8:30–9:00 AM).',
    ],
    rules: [
      'The contest runs in two phases: an online preliminary round and an onsite final round.',
      'Preliminary: 22 August 2026 — 2 hours, 5 problems, held online.',
      'Final: 29 August 2026 — 3 hours (9:15 AM – 12:15 PM), 9 problems, onsite at UGV CSE labs (B2 block).',
      'Allowed languages in both rounds: C, C++, Java and Python.',
      'Problems are set by the university problem-setting committee (UGV: Saif Hasan, Md Mahfuzur Rahman, Hasnat Nihal).',
      'Ranking follows standard ICPC convention: problems solved first, then penalty time.',
      'Judge clarification and final score verification run 12:15–1:45 PM, before the prize-giving ceremony.',
      'The judging committee\'s verdict is final.',
    ],
    schedule: [
      ['23 JUL', 'Registration opens (online round)'],
      ['10–12 AUG', 'Problem submission & review'],
      ['20 AUG', 'Registration closes · lab setup'],
      ['22 AUG', 'Online preliminary round'],
      ['29 AUG', 'Onsite final + prize giving (1:45–2:30 PM)'],
    ],
    prizes: [
      ['CHAMPION', 'TROPHY'],
      ['1ST RUNNER-UP', 'TROPHY'],
      ['2ND RUNNER-UP', 'TROPHY'],
      ['ALL PARTICIPANTS', 'CERTIFICATE'],
    ],
  },

  jpc: {
    accent: 'cyber',
    kicker: 'Junior programming track',
    title: 'Junior Programming Contest',
    chips: ['SCHOOL · COLLEGE · POLYTECHNIC', '2–3 MEMBERS', 'SCRATCH FRIENDLY'],
    overview: 'JPC-2026 builds the early pipeline: school, college and polytechnic students take on beginner-to-intermediate problems in levelled categories — online prelim on 20 August, onsite final on 29 August in a dedicated junior lab block.',
    meta: [
      ['LEVEL', 'SCHOOL / COLLEGE / POLYTECHNIC'],
      ['PRELIM', '20 AUG · ONLINE · 1.5H · 4 PROBLEMS'],
      ['FINAL', '29 AUG · ONSITE · 3H · 6 PROBLEMS'],
      ['FEE', '৳500 / TEAM'],
    ],
    eligibility: [
      'School & College category: SSC and HSC 1st/2nd year students.',
      'Polytechnic category: Diploma in Engineering students (all years).',
      'Teams of 2–3 members; 15–20 institutions expected (60–70 teams, 180–220 students).',
    ],
    rules: [
      'Two phases: online preliminary (20 August) and onsite final (29 August).',
      'Preliminary: 1.5 hours, 4 problems — Scratch, C, C++ or Python allowed.',
      'Final: 3 hours, 6 problems — C, C++ or Python.',
      'The junior final runs in a separate lab block (B2-101) alongside the main SZPC final.',
      'Problems and difficulty are levelled separately for each category.',
      'Preliminary results publish on 22 August with final invitations for qualified teams.',
    ],
    schedule: [
      ['27 JUL', 'Registration opens'],
      ['15 AUG', 'Problem setting & review'],
      ['17 AUG', 'Registration closes'],
      ['20 AUG', 'Online preliminary round'],
      ['22 AUG', 'Results & final invitations'],
      ['29 AUG', 'Onsite final + combined prize giving'],
    ],
    prizes: [
      ['CHAMPION (PER CATEGORY)', 'TROPHY'],
      ['1ST RUNNER-UP (PER CATEGORY)', 'TROPHY'],
      ['2ND RUNNER-UP (PER CATEGORY)', 'TROPHY'],
      ['TOP 10 PRELIM (PER CATEGORY)', 'MERIT CERTIFICATE'],
      ['ALL PARTICIPANTS', 'CERTIFICATE'],
    ],
  },

  ithq: {
    accent: 'neon',
    kicker: 'ICT quiz olympiad',
    title: 'ICT Talent Hunt Quiz',
    chips: ['INDIVIDUAL', 'SCHOOL & COLLEGE', 'LIVE BUZZER FINAL'],
    overview: 'ITHQ-2026 is an individual ICT knowledge showdown — computer fundamentals, digital safety, networks and current tech trends. A written screening cuts the field to the top 8 per category, who face the live buzzer final in the UGV auditorium.',
    meta: [
      ['FORMAT', 'INDIVIDUAL'],
      ['SCREENING', '20 AUG · WRITTEN'],
      ['FINAL', '29 AUG · 3:00–4:00 PM · BUZZER'],
      ['FEE', '৳100 / PERSON'],
    ],
    eligibility: [
      'School category: class 6–10 students.',
      'College category: HSC 1st & 2nd year students.',
      'Individual registration only; 150–200 participants expected from 15–20 institutions.',
    ],
    rules: [
      'School category topics: computer basics, ICT in daily life, digital safety, general tech awareness.',
      'College category topics: programming basics, CS fundamentals, internet & networks, current tech trends.',
      'Written screening round on 20 August; results published 22 August.',
      'Top 8 per category advance to the onsite buzzer final in the auditorium.',
      'The final runs 29 August, 3:00–4:00 PM — MCQ and written format with live buzzers.',
      'A special recognition goes to the fastest correct-answer streak in the buzzer final.',
    ],
    schedule: [
      ['27 JUL', 'Registration opens'],
      ['01 AUG', 'Question bank preparation'],
      ['17 AUG', 'Registration closes'],
      ['20 AUG', 'Written screening round'],
      ['22 AUG', 'Results: top 8 per category'],
      ['29 AUG', 'Onsite buzzer final + prize giving'],
    ],
    prizes: [
      ['CHAMPION (PER CATEGORY)', 'TROPHY'],
      ['1ST RUNNER-UP (PER CATEGORY)', 'TROPHY'],
      ['2ND RUNNER-UP (PER CATEGORY)', 'TROPHY'],
      ['FASTEST ANSWER STREAK', 'SPECIAL RECOGNITION'],
      ['ALL PARTICIPANTS', 'CERTIFICATE'],
    ],
  },
};

const routes = window.SZPC_ROUTES || { home: '/', homeSegments: '/#segments', register: '/register' };
const params = new URLSearchParams(window.location.search);
const key = params.get('s') || 'szpc';
const seg = SEGMENTS[key];
const root = document.getElementById('segment-root');
const accentText = seg && seg.accent === 'neon' ? 'text-neon' : 'text-cyber';
const accentBorder = seg && seg.accent === 'neon' ? 'border-neon' : 'border-cyber';

if (!seg) {
  root.innerHTML = `
    <div class="max-w-3xl mx-auto px-6 py-32">
      <p class="text-red-400 text-sm font-medium mb-6">Contest not found</p>
      <p class="text-dim text-sm mb-8">The contest you requested does not exist.</p>
      <a href="${routes.homeSegments}" data-testid="back-to-home-link" class="border border-neon text-neon px-6 py-3 text-sm">← Back to contests</a>
    </div>`;
} else {
  root.innerHTML = `
    <section class="blueprint-x border-b border-white/10">
      <div class="max-w-7xl mx-auto px-6 lg:px-12 pt-32 pb-20" data-testid="segment-detail-page">
        <p class="reveal ${accentText} text-sm font-medium mb-6">${seg.kicker}</p>
        <h1 data-testid="segment-detail-title" class="reveal font-display font-800 tracking-tight leading-tight text-4xl sm:text-6xl lg:text-7xl" style="--d:.1s">${seg.title}</h1>
        <div class="reveal flex flex-wrap gap-3 mt-8" style="--d:.2s">
          ${seg.chips.map((c) => `<span class="tag-chip ${accentBorder} ${accentText}">${c}</span>`).join('')}
        </div>
        <p class="reveal max-w-2xl text-sm sm:text-base text-dim leading-relaxed mt-8" style="--d:.3s">${seg.overview}</p>
        <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-4 mt-12" style="--d:.4s">
          ${seg.meta.map(([k, v]) => `<div class="meta-cell"><span>${k}</span><span>${v}</span></div>`).join('')}
        </div>
      </div>
    </section>

    <section class="py-20 lg:py-28">
      <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-14">
        <div class="lg:col-span-4">
          <p class="reveal ${accentText} text-sm font-medium mb-4">Eligibility</p>
          <h2 class="reveal font-display font-800 text-2xl sm:text-3xl tracking-tight mb-8" style="--d:.1s">Who may enter</h2>
          <ul class="reveal space-y-4 text-sm text-dim leading-relaxed" style="--d:.2s" data-testid="detail-eligibility-list">
            ${seg.eligibility.map((e) => `<li class="flex gap-3"><span class="${accentText}">•</span><span>${e}</span></li>`).join('')}
          </ul>

          <p class="reveal ${accentText} text-sm font-medium mt-16 mb-4" style="--d:.3s">Schedule</p>
          <ol class="reveal relative border-l border-white/15 ml-1" style="--d:.4s">
            ${seg.schedule.map(([d, t]) => `
              <li class="timeline-item">
                <span class="timeline-dot"></span>
                <span class="timeline-date">${d}</span>
                <h3 class="timeline-title text-base">${t}</h3>
              </li>`).join('')}
          </ol>
        </div>

        <div class="lg:col-span-8">
          <p class="reveal ${accentText} text-sm font-medium mb-4">Rules</p>
          <h2 class="reveal font-display font-800 text-2xl sm:text-3xl tracking-tight mb-8" style="--d:.1s">Before you register</h2>
          <div class="reveal border-t border-white/10" style="--d:.2s" data-testid="detail-rules-list">
            ${seg.rules.map((r, i) => `<div class="detail-rule"><span>${String(i + 1).padStart(2, '0')}</span><span>${r}</span></div>`).join('')}
          </div>

          <p class="reveal ${accentText} text-sm font-medium mt-16 mb-4" style="--d:.3s">Prizes & recognition</p>
          <div class="reveal border border-white/10" style="--d:.4s" data-testid="detail-prize-list">
            ${seg.prizes.map(([r, a]) => `<div class="prize-row"><span class="tracking-[0.2em] text-xs">${r}</span><span class="font-display font-800 ${accentText}">${a}</span></div>`).join('')}
          </div>

          <div class="reveal mt-14 flex flex-wrap items-center gap-5" style="--d:.5s">
            <a href="${routes.register}?c=${key}" data-testid="detail-register-button" class="bg-neon text-black font-bold px-8 py-4 text-sm tracking-[0.2em] btn-hard">REGISTER FOR THIS CONTEST</a>
            <a href="${routes.homeSegments}" data-testid="detail-all-contests-link" class="border border-white/20 px-8 py-4 text-sm tracking-[0.2em] text-gray-200 hover:border-cyber hover:text-cyber transition-colors duration-300">← ALL CONTESTS</a>
          </div>
        </div>
      </div>
    </section>`;
}

/* reveal on load */
requestAnimationFrame(() => {
  document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
});
document.getElementById('year').textContent = new Date().getFullYear();
