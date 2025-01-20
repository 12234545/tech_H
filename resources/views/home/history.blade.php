@extends('welcome')

@section('title', 'History')

@section('content')
<main class="content6">
    <h1>Historique</h1>

    <!-- Barre de recherche -->
    <input type="text" id="searchInput" class="search-bar" placeholder="Rechercher par titre..." onkeyup="searchHistory()">

    <div class="history-filters">
        <h2>Thèmes</h2>
        <div class="filter-chips">
            <button class="filter-chip active" onclick="filterHistory('all')">Tous</button>
            <button class="filter-chip" onclick="filterHistory('Actualités')">Actualités</button>
            <button class="filter-chip" onclick="filterHistory('Technologies')">Technologies</button>
            <button class="filter-chip" onclick="filterHistory('Sports')">Sports</button>
            <button class="filter-chip" onclick="filterHistory('Culture')">Culture</button>
            <button class="filter-chip" onclick="filterHistory('Science')">Science</button>
            <button class="filter-chip" onclick="filterHistory('Économie')">Économie</button>
        </div>
    </div>

    <div class="history-list">
        <div class="history-item" data-theme="Technologies">
            <div class="history-meta">
                <h3>Comment l'IA révolutionne l'industrie automobile</h3>
                <div class="history-theme">Technologies</div>
                <div class="history-date">Consulté il y a 2 heures</div>
            </div>
        </div>

        <div class="history-item" data-theme="Science">
            <div class="history-meta">
                <h3>Les dernières découvertes sur Mars</h3>
                <div class="history-theme">Science</div>
                <div class="history-date">Consulté il y a 1 jour</div>
            </div>
        </div>

        <div class="history-item" data-theme="Sports">
            <div class="history-meta">
                <h3>Résultats du championnat mondial</h3>
                <div class="history-theme">Sports</div>
                <div class="history-date">Consulté il y a 2 jours</div>
            </div>
        </div>
    </div>
</main>
@endsection
