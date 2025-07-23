
  <style>
    .tabs {
      display: flex;
      margin-bottom: 1rem;
      border-bottom: 2px solid #ccc;
    }
    .tab {
    	outline: none !important;
      padding: 10px 20px;
      cursor: pointer;
      border: none;
      background: none;
      font-weight: bold;
      border-bottom: 3px solid transparent;
    }
    .tab.active {
      border-color: #007bff;
      color: #007bff;
    }
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
      padding: 1rem;
      background: #f9f9f9;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <div class="tabs">
    <button class="tab active" data-tab="tab1">Общее</button>
    <button class="tab" data-tab="tab2">Настройки</button>
    <button class="tab" data-tab="tab3">Дополнительно</button>
  </div>

  <div id="tab1" class="tab-content active">
    <p>Контент во вкладке «Общее».</p>
  </div>
  <div id="tab2" class="tab-content">
    <p>Контент во вкладке «Настройки».</p>
  </div>
  <div id="tab3" class="tab-content">
    <p>Контент во вкладке «Дополнительно».</p>
  </div>

  <script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
      });
    });
  </script>