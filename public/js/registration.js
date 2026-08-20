/* SZPC '26 — branched registration form (design only, spec-driven, no backend) */

const FORM_SPEC = {
  form: 'UGV Contest Registration 2026',
  entry_field: 'contest_type',
  branches: {
    'SZPC-2026': {
      team_name: { type: 'text', required: true },
      university: { type: 'text', required: true },
      email: { type: 'email', required: false },
      member1: {
        full_name: { type: 'text', required: true },
        tshirt: { type: 'radio', required: true, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
        phone: { type: 'text', required: true },
      },
      member2: {
        full_name: { type: 'text', required: false },
        tshirt: { type: 'radio', required: false, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
      },
      member3: {
        full_name: { type: 'text', required: false },
        tshirt: { type: 'radio', required: false, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
      },
    },
    'JPC-2026': {
      category: { type: 'select', required: true, options: ['School', 'College', 'Polytechnic'] },
      institution_name: { type: 'text', required: true },
      district: { type: 'text', required: true },
      team_name: { type: 'text', required: true },
      email: { type: 'email', required: true },
      member1: {
        full_name: { type: 'text', required: true },
        phone: { type: 'text', required: true },
        tshirt: { type: 'radio', required: true, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
      },
      member2: {
        full_name: { type: 'text', required: false },
        tshirt: { type: 'radio', required: false, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
      },
      member3: {
        full_name: { type: 'text', required: false },
        tshirt: { type: 'radio', required: false, options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
      },
    },
    'ITHQ-2026': {
      category: { type: 'select', required: true, options: ['School', 'College', 'Polytechnic'] },
      full_name: { type: 'text', required: true },
      institution_name: { type: 'text', required: true },
      email: { type: 'email', required: true },
      phone: { type: 'text', required: true },
      address: { type: 'text', required: true },
    },
  },
};

const LABELS = {
  team_name: 'Team name',
  university: 'University',
  email: 'Email',
  full_name: 'Full name',
  tshirt: 'T-shirt size',
  phone: 'Phone number',
  category: 'Category',
  institution_name: 'Institution name',
  district: 'District',
  address: 'Address',
};
const MEMBER_TITLES = {
  member1: 'Member 1 — team lead',
  member2: 'Member 2 (optional)',
  member3: 'Member 3 (optional)',
};

const PLACEHOLDERS = {
  team_name: 'e.g. UGV Bit Warriors',
  university: 'e.g. University of Global Village',
  email: 'you@university.edu',
  full_name: 'Full legal name',
  phone: '01XXXXXXXXX',
  institution_name: 'School, college or polytechnic name',
  district: 'e.g. Barishal',
  address: 'City, district',
};

const regForm = document.getElementById('reg-form');
const fieldsRoot = document.getElementById('form-fields');
const regError = document.getElementById('form-error');
const regSuccess = document.getElementById('reg-success');
const selector = document.querySelector('[data-testid="contest-type-selector"]');
let activeContest = null;

const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
const labelOf = (k) => LABELS[k] || k.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
const reqMark = (def) => (def.required ? '<span class="req"> *</span>' : '');
const placeholderOf = (key) => PLACEHOLDERS[key] || '';

function fieldHtml(key, def, prefix) {
  const id = `f-${prefix}${key}`;
  if (def.type === 'select') {
    return `<div class="field">
      <label for="${id}" class="field-label">${labelOf(key)}${reqMark(def)}</label>
      <select id="${id}" name="${prefix}${key}" data-testid="field-${prefix}${key}" class="field-input" ${def.required ? 'required' : ''}>
        <option value="" disabled selected>Select an option</option>
        ${def.options.map((o) => `<option value="${o}">${o}</option>`).join('')}
      </select>
    </div>`;
  }
  if (def.type === 'radio') {
    return `<div class="field sm:col-span-2">
      <span class="field-label">${labelOf(key)}${reqMark(def)}</span>
      <div class="tshirt-group" data-testid="field-${prefix}${key}">
        ${def.options.map((o) => `<label class="tshirt-pill"><input type="radio" name="${prefix}${key}" value="${o}" /><span>${o}</span></label>`).join('')}
      </div>
    </div>`;
  }
  const ph = placeholderOf(key) ? ` placeholder="${esc(placeholderOf(key))}"` : '';
  const inputType = def.type === 'email' ? 'email' : 'text';
  const autoComplete = key === 'email' ? 'email' : key === 'phone' ? 'tel' : key.includes('name') ? 'name' : 'off';
  return `<div class="field">
    <label for="${id}" class="field-label">${labelOf(key)}${reqMark(def)}</label>
    <input id="${id}" name="${prefix}${key}" data-testid="field-${prefix}${key}" type="${inputType}" class="field-input"${ph} autocomplete="${autoComplete}" ${def.required ? 'required' : ''} />
  </div>`;
}

function buildForm(contest) {
  const branch = FORM_SPEC.branches[contest];
  let html = `<h3 class="register-step-title">Step 2 — ${contest} details</h3>`;
  html += '<p class="register-step-hint">Fields marked with <span class="req">*</span> are required.</p>';
  html += '<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 w-full min-w-0">';
  Object.entries(branch).forEach(([k, v]) => { if (v.type) html += fieldHtml(k, v, ''); });
  html += '</div>';
  Object.entries(branch).forEach(([k, v]) => {
    if (!v.type) {
      html += `<div class="member-block" data-testid="member-block-${k}">
        <p class="member-title">${MEMBER_TITLES[k] || k.toUpperCase()}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-7 w-full min-w-0">
          ${Object.entries(v).map(([fk, fd]) => fieldHtml(fk, fd, `${k}_`)).join('')}
        </div>
      </div>`;
    }
  });
  fieldsRoot.innerHTML = html;
}

function walkBranch(branch, cb, prefix = '') {
  Object.entries(branch).forEach(([k, v]) => {
    if (v.type) cb(k, v, prefix);
    else walkBranch(v, cb, `${k}_`);
  });
}

function getValue(key, def, prefix) {
  if (def.type === 'radio') {
    const el = fieldsRoot.querySelector(`input[name="${prefix}${key}"]:checked`);
    return el ? el.value : '';
  }
  const el = fieldsRoot.querySelector(`[name="${prefix}${key}"]`);
  return el ? el.value.trim() : '';
}

document.querySelectorAll('.contest-card').forEach((btn) => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.contest-card').forEach((b) => b.classList.remove('selected'));
    btn.classList.add('selected');
    activeContest = btn.dataset.contest;
    const contestInput = document.getElementById('contest-type-input');
    if (contestInput) contestInput.value = activeContest;
    buildForm(activeContest);
    regForm.classList.remove('hidden');
    regError.classList.add('hidden');
    regForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });
});

const appendHidden = (name, value) => {
  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = name;
  input.value = value;
  input.className = 'dynamic-field';
  regForm.appendChild(input);
};

regForm.addEventListener('submit', (e) => {
  if (!activeContest) {
    e.preventDefault();
    return;
  }
  const branch = FORM_SPEC.branches[activeContest];
  const missing = [];
  walkBranch(branch, (k, def, prefix) => {
    if (def.required && !getValue(k, def, prefix)) {
      missing.push(prefix ? `${prefix.replace(/_$/, '').toUpperCase()} ${labelOf(k)}` : labelOf(k));
    }
  });
  if (missing.length) {
    e.preventDefault();
    regError.textContent = `Please fill in required fields: ${missing.join(' · ')}`;
    regError.classList.remove('hidden');
    return;
  }
  regError.classList.add('hidden');

  regForm.querySelectorAll('input.dynamic-field').forEach((el) => el.remove());
  walkBranch(branch, (k, def, prefix) => {
    const val = getValue(k, def, prefix);
    if (val) appendHidden(`${prefix}${k}`, val);
  });
  document.getElementById('contest-type-input').value = activeContest;
});

document.getElementById('reg-again').addEventListener('click', () => {
  regSuccess.classList.add('hidden');
  regForm.reset();
  fieldsRoot.innerHTML = '';
  regForm.classList.add('hidden');
  document.querySelectorAll('.contest-card').forEach((b) => b.classList.remove('selected'));
  selector.classList.remove('hidden');
  activeContest = null;
});


/* ---------- preselect contest via ?c= param (from contest detail pages) ---------- */
const PRESELECT_MAP = { szpc: 'SZPC-2026', jpc: 'JPC-2026', ithq: 'ITHQ-2026' };
const preParam = new URLSearchParams(window.location.search).get('c');
const preContest = PRESELECT_MAP[(preParam || '').toLowerCase()] || (FORM_SPEC.branches[preParam] ? preParam : null);
if (preContest) {
  const preBtn = document.querySelector(`.contest-card[data-contest="${preContest}"]`);
  if (preBtn) preBtn.click();
}
