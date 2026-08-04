/* SZPC '26 — vanilla JS interactions */

document.body.classList.add('loaded');

const scrollToTarget = (el) => {
  el.scrollIntoView({ behavior: 'smooth' });
};

document.querySelectorAll('.nav-anchor').forEach((a) => {
  a.addEventListener('click', (e) => {
    const href = a.getAttribute('href');
    if (href && href.startsWith('#')) {
      e.preventDefault();
      closeMenu();
      const target = document.querySelector(href);
      if (target) scrollToTarget(target);
    }
  });
});

/* ---------- mobile menu ---------- */
const menu = document.getElementById('mobile-menu');
const openMenu = () => { menu.classList.remove('hidden'); menu.classList.add('open'); };
const closeMenu = () => { menu.classList.add('hidden'); menu.classList.remove('open'); };
document.getElementById('menu-toggle').addEventListener('click', openMenu);
document.getElementById('menu-close').addEventListener('click', closeMenu);

/* ---------- countdown ---------- */
const TARGET = new Date('2026-08-29T09:15:00+06:00').getTime();
const pad = (n) => String(n).padStart(2, '0');
const cd = {
  days: document.getElementById('cd-days'),
  hours: document.getElementById('cd-hours'),
  mins: document.getElementById('cd-mins'),
  secs: document.getElementById('cd-secs'),
};
const tick = () => {
  const diff = Math.max(0, TARGET - Date.now());
  const d = Math.floor(diff / 86400000);
  const h = Math.floor((diff % 86400000) / 3600000);
  const m = Math.floor((diff % 3600000) / 60000);
  const s = Math.floor((diff % 60000) / 1000);
  if (cd.days) cd.days.textContent = pad(d);
  if (cd.hours) cd.hours.textContent = pad(h);
  if (cd.mins) cd.mins.textContent = pad(m);
  if (cd.secs) cd.secs.textContent = pad(s);
};
tick();
setInterval(tick, 1000);

/* ---------- FAQ accordion ---------- */
document.querySelectorAll('.faq-item').forEach((item) => {
  item.querySelector('.faq-q').addEventListener('click', () => {
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach((i) => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  });
});

/* ---------- copy registration link buttons ---------- */
document.querySelectorAll('.copy-link-btn').forEach((btn) => {
  btn.addEventListener('click', async () => {
    const raw = btn.dataset.copy || '';
    const url = /^https?:\/\//i.test(raw)
      ? raw
      : `${window.location.origin}${raw.startsWith('/') ? raw : `/${raw}`}`;
    try {
      await navigator.clipboard.writeText(url);
    } catch (err) {
      const ta = document.createElement('textarea');
      ta.value = url;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      ta.remove();
    }
    btn.classList.add('copied');
    btn.textContent = 'LINK COPIED ✓';
    setTimeout(() => {
      btn.classList.remove('copied');
      btn.textContent = 'COPY LINK';
    }, 2200);
  });
});
