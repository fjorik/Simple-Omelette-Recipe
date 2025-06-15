<?php
// --- INIZIO BLOCCO DI CONTROLLO SESSIONE --- //
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
// --- FINE BLOCCO DI CONTROLLO SESSIONE --- //
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SPORT ODDSMATCHER</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@600&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #e0e7ff 0%, #f5f7fa 100%);
      font-family: 'Inter', Arial, sans-serif;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: linear-gradient(135deg, #4f8cff 0%, #8f5eff 100%);
      padding: 0 32px;
      height: 70px;
      color: #fff;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 12px rgba(79,140,255,0.09);
    }
    .navbar .nav-left, .navbar .nav-right {
      display: flex;
      align-items: center;
      gap: 24px;
    }
    .navbar .nav-link {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      font-size: 1.08rem;
      padding: 6px 14px;
      border-radius: 5px;
      transition: background 0.2s;
      letter-spacing: 0.5px;
    }
    .navbar .nav-link:hover, .navbar .nav-link.active {
      background: rgba(255,255,255,0.18);
    }
    .navbar .nav-center {
      flex: 1;
      display: flex;
      justify-content: center;
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: 1.6px;
      text-shadow: 0 2px 8px rgba(0,0,0,0.09);
      color: #fff;
    }
    .navbar .profile-section {
      position: relative;
      display: flex;
      align-items: center;
      cursor: pointer;
    }
    .navbar .profile-icon {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: #fff;
      color: #4f8cff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      font-weight: bold;
      margin-left: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.09);
      transition: background 0.2s;
      border: 2px solid #e3f2fd;
    }
    .navbar .profile-icon:hover {
      background: #e3f2fd;
    }
    .profile-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 48px;
      background: #fff;
      color: #222;
      min-width: 200px;
      border-radius: 8px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.13);
      padding: 12px 0;
      z-index: 200;
      font-size: 1rem;
    }
    .profile-dropdown.active {
      display: block;
    }
    .profile-dropdown .dropdown-item {
      padding: 10px 20px;
      cursor: pointer;
      transition: background 0.15s;
      white-space: nowrap;
    }
    .profile-dropdown .dropdown-item:hover {
      background: #f5f7fa;
    }
    .profile-dropdown .dropdown-divider {
      height: 1px;
      background: #e9ecef;
      margin: 7px 0;
    }
    @media (max-width: 700px) {
      .navbar { flex-direction: column; align-items: flex-start; height: auto; padding: 0 10px; }
      .navbar .nav-left, .navbar .nav-right { gap: 10px; }
      .navbar .nav-center { justify-content: flex-start; }
    }
    .container {
      max-width: 1350px;
      margin: 28px auto 30px auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 6px 30px rgba(79,140,255,0.10);
      overflow: hidden;
      padding-bottom: 20px;
      min-height: 600px;
      border: 1px solid #eceeff;
    }
    .filters {
      padding: 20px 32px 16px 32px;
      background: linear-gradient(93deg, #f7f9ff 60%, #e0eaff 100%);
      border-bottom: 1px solid #e1e5e9;
      display: flex;
      gap: 34px;
      align-items: center;
      flex-wrap: wrap;
      min-height: 72px;
    }
    .filter-group {
      display: flex;
      gap: 12px;
      align-items: center;
      flex-wrap: wrap;
    }
    .filter-label {
      font-weight: 600;
      color: #4f8cff;
      font-size: 1.09rem;
      letter-spacing: 0.4px;
      margin-right: 2px;
      font-family: 'Montserrat', Arial, sans-serif;
      text-shadow: 0 1px 5px #e6eaff7d;
    }
    .league-btn {
      font-family: 'Montserrat', Arial, sans-serif;
      background: linear-gradient(90deg, #f0f4ff 70%, #e3eafc 100%);
      color: #4f8cff;
      font-weight: 600;
      border: 1.5px solid #dbe7ff;
      border-radius: 7px;
      padding: 6px 20px;
      font-size: 0.97rem;
      margin: 0 1px 4px 0;
      cursor: pointer;
      transition: all 0.15s;
      box-shadow: 0 2px 6px #4f8cff09;
      outline: none;
    }
    .league-btn.selected, .league-btn:active {
      background: linear-gradient(90deg, #4f8cff 70%, #8f5eff 100%);
      color: #fff;
      border: 1.5px solid #6b8cff;
      box-shadow: 0 2px 8px #4f8cff17;
    }
    .odds-table {
      width: 97%;
      margin: 28px auto 0 auto;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 0.97rem;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 18px #8f5eff10;
      background: #fafdff;
    }
    .odds-table th {
      background: linear-gradient(90deg, #f4f9ff 80%, #e2e4ff 100%);
      color: #495057;
      font-weight: 700;
      padding: 14px 8px;
      text-align: center;
      border-bottom: 2px solid #dee2e6;
      font-size: 0.88rem;
      letter-spacing: 0.3px;
      font-family: 'Montserrat', Arial, sans-serif;
      cursor: pointer;
      user-select: none;
      transition: background 0.13s;
      position: relative;
    }
    .odds-table th.sortable:hover {
      background: #e7f0ff;
      color: #1976d2;
    }
    .odds-table th .sort-arrows {
      margin-left: 7px;
      font-size: 1.05em;
      vertical-align: middle;
      display: inline-block;
    }
    .odds-table th.sorted-asc,
    .odds-table th.sorted-desc {
      color: #4f8cff;
      background: #e9f1ff;
    }
    .odds-table td {
      padding: 12px 8px;
      text-align: center;
      border-bottom: 1px solid #e9ecef;
      vertical-align: middle;
      background: #fff;
      font-size: 1.01rem;
    }
    .odds-table tr:hover td {
      background: #f1f7ff;
    }
    .match-info {
      text-align: left; 
      max-width: 210px;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .ball-emoji {
      font-size: 1.15em;
      margin-right: 2px;
    }
    .match-teams { font-weight: 600; color: #212529; margin-bottom: 2px; }
    .odds-value.negative { color: #dc3545; }
    .odds-value.positive { color: #28a745; }
    .profit { color: #28a745; font-weight: 600; }
    .lay-odds { color: #ff9800; font-weight: 600; }
    .bookmaker-chip {
      display: inline-block;
      font-family: 'Montserrat', Arial, sans-serif;
      font-weight: 700;
      border-radius: 20px;
      padding: 5px 16px 5px 16px;
      font-size: 0.98rem;
      margin: 0 2px;
      transition: background 0.18s, color 0.18s, box-shadow 0.18s;
      box-shadow: 0 2px 8px #4f8cff10;
      border: 2px solid transparent;
      text-shadow: 0 1px 8px #fff3;
      cursor: pointer;
    }
    .bookmaker-winamax { background: #eaf3ff; color: #2b7fd6; border-color: #b4d3f7; }
    .bookmaker-unibet { background: #eafbe6; color: #3a9d36; border-color: #b4eab0;}
    .bookmaker-betclic { background: #fff0f0; color: #d60000; border-color: #ffc1c1;}
    .bookmaker-parionssport { background: #f0faff; color: #11a6c8; border-color: #b6eaff;}
    .bookmaker-pmu { background: #f1fff4; color: #14a12c; border-color: #b0f5c1;}
    .bookmaker-vbet { background: #fbeaff; color: #a935a9; border-color: #e9b4f7;}
    .bookmaker-bwin { background: #fffbea; color: #d6a72b; border-color: #f7e2b4;}
    .bookmaker-netbet { background: #fef6ea; color: #d67a2b; border-color: #f7dab4;}
    .bookmaker-betsson { background: #fff6ea; color: #d68a2b; border-color: #f7e6b4;}
    .bookmaker-pokerstars { background: #ffeaea; color: #d62b2b; border-color: #f7b4b4;}
    .bookmaker-olybet { background: #fef5ee; color: #d6622b; border-color: #f7ceb4;}
    .bookmaker-chip:hover {
      box-shadow: 0 4px 14px #4f8cff2e;
      opacity: 0.93;
      filter: brightness(1.08);
    }
    .logout-container { display: none; }
    .logout-btn { display: none; }
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      margin: 28px 0 8px 0;
    }
    .pagination-btn {
      background: #e3f2fd;
      color: #1976d2;
      border: none;
      border-radius: 4px;
      padding: 6px 18px;
      font-size: 1.04rem;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.14s, color 0.14s;
      margin: 0 1px;
    }
    .pagination-btn.active, .pagination-btn:hover {
      background: #4f8cff;
      color: #fff;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <a href="homepage.php" class="nav-link active">Home</a>
    </div>
    <div class="nav-center">
      SPORT ODDSMATCHER
    </div>
    <div class="nav-right">
      <a href="contact.html" class="nav-link">Contact Us</a>
      <div class="profile-section" id="profileSection">
        <span class="profile-icon" id="profileIcon">&#128100;</span>
        <div class="profile-dropdown" id="profileDropdown">
          <div class="dropdown-item" style="font-weight:600;">Profilo</div>
          <div class="dropdown-divider"></div>
          <div class="dropdown-item" onclick="window.location='settings.html'">Settings</div>
          <div class="dropdown-item" onclick="window.location='logout.php'">Logout</div>
        </div>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="filters">
      <div class="filter-group" id="leagueFilter">
        <span class="filter-label">Seleziona Lega:</span>
      </div>
    </div>
    <table class="odds-table" id="oddsTable">
      <thead>
        <tr>
          <th class="sortable" data-sort="time">Time <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="match">Match <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="league">League <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="bookmaker">Bookmaker <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="homeOdds">Home Odds <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="awayOdds">Away Odds <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th class="sortable" data-sort="drawOdds">Draw Odds <span class="sort-arrows">&#9650;&#9660;</span></th>
          <th>LAY</th>
          <th class="sortable" data-sort="profit">Profit % <span class="sort-arrows">&#9650;&#9660;</span></th>
        </tr>
      </thead>
      <tbody id="oddsTableBody">
        <!-- Data will be inserted here -->
      </tbody>
    </table>
    <div class="pagination" id="pagination"></div>
  </div>
<script>
/* --- Qui il tuo JS, identico a index.html --- */
const API_KEY = "d6113977d8163a57d3fb8f915f14efb4";
let selectedLeague = null;
let allRows = [];
let allLeagues = [];
let currentPage = 1;
const PAGE_SIZE = 12;

let currentSort = { column: "time", direction: "asc" };

// Bookmaker CSS class mapping
const bookmakerClassMap = {
  "winamax": "bookmaker-winamax",
  "unibet": "bookmaker-unibet",
  "betclic": "bookmaker-betclic",
  "parions sport": "bookmaker-parionssport",
  "pmu": "bookmaker-pmu",
  "vbet": "bookmaker-vbet",
  "bwin": "bookmaker-bwin",
  "netbet": "bookmaker-netbet",
  "betsson": "bookmaker-betsson",
  "pokerstars": "bookmaker-pokerstars",
  "olybet": "bookmaker-olybet"
};
const bookmakerLinks = {
  "winamax": "https://www.winamax.fr/",
  "unibet": "https://www.unibet.fr/",
  "betclic": "https://www.betclic.fr/",
  "parions sport": "https://www.enligne.parionssport.fdj.fr/",
  "pmu": "https://www.pmu.fr/",
  "vbet": "https://www.vbet.fr/",
  "bwin": "https://www.bwin.fr/",
  "netbet": "https://www.netbet.fr/",
  "betsson": "https://www.betsson.fr/",
  "pokerstars": "https://www.pokerstars.fr/sports/",
  "olybet": "https://www.olybet.fr/"
};
const allowedBookmakers = [
  "winamax", "unibet", "betclic", "parions sport", "pmu", "vbet", "bwin", "netbet", "betsson", "pokerstars", "olybet"
];
function cleanBookmakerTitle(name) {
  return name
    .replace(/\([^)]*\)/g, '')
    .replace(/\b(AU|US|UK|FR|IT|ES|DE|NL|PL|BE|IN|SE|NO|DK|FI|RU)\b/gi, '')
    .replace(/\d+/g, '')
    .replace(/[\[\]\{\}]/g, '')
    .replace(/\s+/g, ' ')
    .trim().toLowerCase();
}
function getBookmakerLink(name) {
  const key = Object.keys(bookmakerLinks).find(linkKey =>
    cleanBookmakerTitle(name).includes(linkKey)
  );
  return key ? bookmakerLinks[key] : "#";
}
function getBookmakerClass(name) {
  const key = Object.keys(bookmakerClassMap).find(linkKey =>
    cleanBookmakerTitle(name).includes(linkKey)
  );
  return key ? bookmakerClassMap[key] : "";
}
function getBookmakerDisplayName(name) {
  let clean = cleanBookmakerTitle(name);
  if (!clean) return name;
  return clean.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
}
function formatOdds(price) {
  if (typeof price !== 'number') return 'N/A';
  if (price > 0) return `<span class="odds-value positive">+${price}</span>`;
  return `<span class="odds-value negative">${price}</span>`;
}
function randomProfit() {
  return (Math.random() * 10 + 90).toFixed(2);
}
function getLayOdds(row) {
  return '-';
}
function renderLeagueFilter() {
  const leagueDiv = document.getElementById('leagueFilter');
  leagueDiv.innerHTML = `<span class="filter-label">Seleziona Lega:</span>`;
  const uniqueLeagues = Array.from(new Set(allLeagues)).sort();
  uniqueLeagues.forEach(league => {
    const btn = document.createElement('button');
    btn.className = 'league-btn' + (selectedLeague === league ? ' selected' : '');
    btn.textContent = league;
    btn.onclick = () => {
      selectedLeague = league;
      currentPage = 1;
      renderLeagueFilter();
      renderTable(allRows);
    };
    leagueDiv.appendChild(btn);
  });
  if (!selectedLeague && uniqueLeagues.length > 0) {
    selectedLeague = uniqueLeagues[0];
    setTimeout(() => {
      renderLeagueFilter();
      renderTable(allRows);
    }, 0);
  }
}
function compareValues(a, b, col, dir) {
  if (col === 'time' && a.rawTime && b.rawTime) {
    if (a.rawTime === b.rawTime) return 0;
    return (a.rawTime < b.rawTime ? -1 : 1) * (dir === "asc" ? 1 : -1);
  }
  if (['homeOdds', 'awayOdds', 'drawOdds', 'profit'].includes(col)) {
    let av = a[col], bv = b[col];
    av = (av === 'N/A' || av === undefined || av === '') ? -Infinity : Number(av);
    bv = (bv === 'N/A' || bv === undefined || bv === '') ? -Infinity : Number(bv);
    if (av === bv) return 0;
    return (av < bv ? -1 : 1) * (dir === "asc" ? 1 : -1);
  }
  let av = (a[col] || '').toString().toLowerCase();
  let bv = (b[col] || '').toString().toLowerCase();
  if (av === bv) return 0;
  return (av < bv ? -1 : 1) * (dir === "asc" ? 1 : -1);
}
function renderTable(rows) {
  const tableBody = document.getElementById('oddsTableBody');
  let filtered = rows;
  if (selectedLeague) {
    filtered = rows.filter(r => r.league === selectedLeague);
  }
  if (currentSort && currentSort.column) {
    filtered = filtered.slice().sort((a, b) => compareValues(a, b, currentSort.column, currentSort.direction));
  }
  const totalPages = Math.ceil(filtered.length / PAGE_SIZE);
  if (currentPage < 1 || currentPage > totalPages) currentPage = 1;
  const start = (currentPage - 1) * PAGE_SIZE;
  const end = start + PAGE_SIZE;
  const pageRows = filtered.slice(start, end);
  if (!pageRows.length) {
    tableBody.innerHTML = `<tr><td colspan="9" style="text-align:center;padding:20px;">No odds data available.</td></tr>`;
    document.getElementById('pagination').innerHTML = '';
    return;
  }
  tableBody.innerHTML = pageRows.map(row => `
    <tr>
      <td>${row.time}</td>
      <td class="match-info"><span class="ball-emoji">⚽</span><div class="match-teams">${row.match}</div></td>
      <td>${row.league}</td>
      <td>
        <a href="${getBookmakerLink(row.bookmaker)}" target="_blank"
          class="bookmaker-chip ${getBookmakerClass(row.bookmaker)}"
          title="${getBookmakerDisplayName(row.bookmaker)}">
          ${getBookmakerDisplayName(row.bookmaker)}
        </a>
      </td>
      <td>${formatOdds(row.homeOdds)}</td>
      <td>${formatOdds(row.awayOdds)}</td>
      <td>${row.drawOdds !== undefined && row.drawOdds !== '' ? formatOdds(row.drawOdds) : '-'}</td>
      <td>${getLayOdds(row)}</td>
      <td class="profit">${row.profit}%</td>
    </tr>
  `).join('');
  renderPagination(totalPages);
  updateSortIndicators();
}
function renderPagination(totalPages) {
  const pagDiv = document.getElementById('pagination');
  if (totalPages <= 1) {
    pagDiv.innerHTML = '';
    return;
  }
  let html = '';
  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="pagination-btn${i === currentPage ? ' active' : ''}" onclick="goToPage(${i})">${i}</button>`;
  }
  pagDiv.innerHTML = html;
}
window.goToPage = function(page) {
  currentPage = page;
  renderTable(allRows);
};
function updateSortIndicators() {
  const headers = document.querySelectorAll('.odds-table th.sortable');
  headers.forEach(th => {
    th.classList.remove('sorted-asc', 'sorted-desc');
    const col = th.getAttribute('data-sort');
    if (col === currentSort.column) {
      th.classList.add(currentSort.direction === "asc" ? "sorted-asc" : "sorted-desc");
      th.querySelector('.sort-arrows').innerHTML = currentSort.direction === "asc" ? "&#9650;&#9660;" : "&#9660;&#9650;";
    } else {
      th.querySelector('.sort-arrows').innerHTML = "&#9650;&#9660;";
    }
  });
}
function addSortEvents() {
  const headers = document.querySelectorAll('.odds-table th.sortable');
  headers.forEach(th => {
    const col = th.getAttribute('data-sort');
    th.onclick = () => {
      if (currentSort.column === col) {
        currentSort.direction = currentSort.direction === "asc" ? "desc" : "asc";
      } else {
        currentSort.column = col;
        currentSort.direction = (col === "time" || col === "profit" || col.endsWith("Odds")) ? "desc" : "asc";
      }
      renderTable(allRows);
    };
  });
}
function fetchAndShowLeagues() {
  document.getElementById('leagueFilter').innerHTML = `<span class="filter-label">Seleziona Lega:</span> <span>Caricamento...</span>`;
  document.getElementById('oddsTableBody').innerHTML = `<tr><td colspan="9" style="text-align:center;padding:20px;">Loading odds...</td></tr>`;
  document.getElementById('pagination').innerHTML = '';
  fetch(`https://api.the-odds-api.com/v4/sports/?apiKey=${API_KEY}`)
    .then(response => response.json())
    .then(sports => {
      const soccerSports = sports.filter(s => s.active && s.group && s.group.toLowerCase().includes("soccer"));
      let fetches = soccerSports.map(sport =>
        fetch(`https://api.the-odds-api.com/v4/sports/${sport.key}/odds/?apiKey=${API_KEY}&regions=us,uk,eu,au&markets=h2h&oddsFormat=american`)
          .then(response => response.json())
          .then(events => ({ sport, events }))
      );
      Promise.all(fetches).then(results => {
        let rows = [];
        let leagues = [];
        results.forEach(({ sport, events }) => {
          if (Array.isArray(events) && events.length > 0) {
            events.forEach(event => {
              const eventTime = new Date(event.commence_time);
              event.bookmakers.forEach(bookmaker => {
                if (!allowedBookmakers.some(ab => bookmaker.title.toLowerCase().includes(ab))) return;
                const market = bookmaker.markets.find(m => m.key === 'h2h');
                if (!market) return;
                const outcomes = market.outcomes;
                const homeOdds = outcomes.find(o => o.name === event.home_team);
                const awayOdds = outcomes.find(o => o.name === event.away_team);
                const drawOdds = outcomes.find(o => o.name && o.name.toLowerCase() === "draw");
                leagues.push(sport.title);
                rows.push({
                  time: eventTime.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}),
                  rawTime: eventTime.getTime(),
                  match: `${event.home_team} vs ${event.away_team}`,
                  league: sport.title,
                  bookmaker: bookmaker.title,
                  homeOdds: homeOdds ? homeOdds.price : 'N/A',
                  awayOdds: awayOdds ? awayOdds.price : 'N/A',
                  drawOdds: drawOdds ? drawOdds.price : '',
                  profit: randomProfit()
                });
              });
            });
          }
        });
        allRows = rows;
        allLeagues = leagues;
        selectedLeague = null;
        currentPage = 1;
        renderLeagueFilter();
        renderTable(allRows);
        addSortEvents();
      });
    });
}
document.addEventListener('DOMContentLoaded', function() {
  fetchAndShowLeagues();
  const profileIcon = document.getElementById('profileIcon');
  const profileDropdown = document.getElementById('profileDropdown');
  profileIcon.addEventListener('click', function(e) {
    profileDropdown.classList.toggle('active');
    e.stopPropagation();
  });
  document.body.addEventListener('click', function() {
    profileDropdown.classList.remove('active');
  });
});
</script>
</body>
</html>