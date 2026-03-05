/* ============================================================
   SmartSpecs — Main JavaScript
   ============================================================ */

(function () {
  'use strict';

  /* ── Nav: shrink on scroll ─────────────────────────────── */
  const nav = document.getElementById('main-nav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
  }

  /* ── Fade-in observer ──────────────────────────────────── */
  const fadeEls = document.querySelectorAll('.fade-in');
  if (fadeEls.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    fadeEls.forEach(el => {
      el.style.animationPlayState = 'paused';
      observer.observe(el);
    });
  }

  /* ── Color dot hover on specs page ────────────────────── */
  document.querySelectorAll('.specs-colors .color-dot').forEach(dot => {
    dot.addEventListener('mouseenter', () => {
      dot.style.transform = 'scale(1.25)';
    });
    dot.addEventListener('mouseleave', () => {
      dot.style.transform = 'scale(1)';
    });
  });

  /* ── Compare badge (basic UI feedback) ─────────────────── */
  document.querySelectorAll('.compare-badge').forEach(badge => {
    badge.addEventListener('click', (e) => {
      e.stopPropagation();
      badge.textContent = badge.textContent.includes('+') ? '✓ Added' : '+ Compare';
      badge.style.borderColor = badge.textContent.includes('Added') ? 'var(--accent)' : '';
      badge.style.color       = badge.textContent.includes('Added') ? 'var(--accent)' : '';
    });
  });

  /* ── Smooth image load ─────────────────────────────────── */
  document.querySelectorAll('.phone-card-img img, .specs-hero-image img').forEach(img => {
    img.style.opacity = '0';
    img.style.transition = 'opacity .4s ease';
    const show = () => { img.style.opacity = '1'; };
    if (img.complete) show();
    else img.addEventListener('load', show);
  });

})();
