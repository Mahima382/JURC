document.addEventListener('DOMContentLoaded', () => {
  try {
    const projects = [
      {
        id: 1,
        title: 'Soccer Board',
        short: 'An interactive robot soccer board that simulates ball movement and autonomous agents for strategy testing.',
        tags: ['soccer','simulation'],
        image: 'images/lfr.jpg',
        desc: 'Soccer Board is a tabletop field with motorized pucks and sensors. It supports multi-agent strategies, path planning tests, and real-time visual telemetry.',
        team: ['S. Ahmed', 'R. Das'],
        tech: ['Arduino', 'Motor Drivers', 'Python']
      },
      {
        id: 2,
        title: 'LFR — Line Following Robot',
        short: 'Compact line follower robot (LFR) using IR sensor array and PID control for smooth tracking.',
        tags: ['lfr','autonomous'],
        image: 'images/soccer.avif',
        desc: 'LFR is built for accuracy and speed on curved tracks. Uses a 5-sensor IR array, PID tuning, and adaptive speed control to handle curves and junctions.',
        team: ['A. Rahman', 'N. Chowdhury'],
        tech: ['Arduino', 'IR Sensors', 'C++']
      },
      {
        id: 3,
        title: 'Vision-Guided Drone',
        short: 'Light drone with onboard computer vision for object detection and tracking during demos.',
        tags: ['drone','ai'],
        image: 'images/droone.jpg',
        desc: 'A demo drone that detects colored markers and tracks simple objects using OpenCV. Includes latency optimisation and safe landing behavior.',
        team: ['L. Karim', 'M. Akter'],
        tech: ['Raspberry Pi', 'OpenCV', 'ROS']
      }
    ];

    const grid = document.getElementById('projectsGrid');
    const appInner = document.getElementById('appInner');
    const wrap = document.getElementById('wrap');
    const detailPanel = document.getElementById('detailPanel');
    const overlay = document.getElementById('overlay');

    if (!grid || !appInner || !wrap || !detailPanel || !overlay) {
      console.error('Required DOM elements not found. Check project.html structure.');
      return;
    }

    function render(list) {
      grid.innerHTML = '';
      list.forEach(p => {
        const card = document.createElement('article');
        card.className = 'card';
        card.innerHTML = `
          <img src="${p.image}" alt="${p.title}">
          <div class="body">
            <h3>${p.title}</h3>
            <p>${p.short}</p>
            <div class="tags">${p.tags.map(t => `<span class='tag'>${t}</span>`).join('')}</div>
            <div class="actions">
              <button class="btn primary" data-id="${p.id}">Details</button>
            </div>
          </div>`;
        grid.appendChild(card);
      });

      document.querySelectorAll('.btn.primary').forEach(b => {
        b.addEventListener('click', e => {
          const id = Number(e.currentTarget.dataset.id);
          openDetailsAnimated(id);
        });
      });
    }

    window.filter = function(tag) {
      if (tag === 'all') render(projects);
      else render(projects.filter(p => p.tags.includes(tag)));
    };

    function openDetailsAnimated(id) {
      const project = projects.find(p => p.id === id);
      if (!project) return;

      wrap.classList.add('slide-up');

      const onTransition = ev => {
        if (ev.target !== appInner) return;
        appInner.removeEventListener('transitionend', onTransition);
        showDetail(project);
      };
      appInner.addEventListener('transitionend', onTransition);
      overlay.classList.add('show');
    }

    function showDetail(project) {
      const setText = (id, text) => {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
      };
      const setImg = (id, src) => {
        const el = document.getElementById(id);
        if (el) el.src = src;
      };

      setText('detailTitle', project.title);
      setText('detailTags', project.tags.join(' • '));
      setImg('detailImage', project.image);
      setText('detailDesc', project.desc);
      setText('detailTeam', project.team.join(', '));
      setText('detailTech', project.tech.join(', '));

      detailPanel.classList.add('show');
      detailPanel.setAttribute('aria-hidden', 'false');
    }

    function closeDetail() {
      detailPanel.classList.remove('show');
      detailPanel.setAttribute('aria-hidden', 'true');
      overlay.classList.remove('show');

      const onPanelEnd = ev => {
        if (ev.propertyName !== 'transform') return;
        detailPanel.removeEventListener('transitionend', onPanelEnd);
        wrap.classList.remove('slide-up');
      };
      detailPanel.addEventListener('transitionend', onPanelEnd);
    }

    const closeBtn = document.getElementById('closeBtn');
    if (closeBtn) closeBtn.addEventListener('click', closeDetail);
    overlay.addEventListener('click', closeDetail);

    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    render(projects);
  } catch (err) {
    console.error('Error initializing project page:', err);
  }
});
