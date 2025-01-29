@extends('welcome')

@section('title', 'Mes Thèmes')

@section('content')
<div class="container30">
    <div class="main-container2">
        <div class="themes-list">
            <h2 style="color: rgb(219, 217, 215); text-align: center; font-size: 35px;">My Themes</h2>

            @if($themes->isEmpty())
                <p>You have not created any themes yet.</p>
            @else
                <div class="themes-grid">
                    @foreach($themes as $theme)

                  <div class="theme-card">
                    <a href="{{ route('admin.theme.articles', $theme->id) }}" class="theme-link">
                      <div class="theme-icon">
                        <ion-icon name="{{ $theme->icon }}"></ion-icon>
                        </div>
        <div class="theme-info">
            <h3>{{ $theme->name }}</h3>
            <p>Articles: {{ $theme->articles_count ?? 0 }}</p>
            <p>Subscribers: {{ $theme->subscribers_count ?? 0 }}</p>
        </div>
    </a>
</div>

                    @endforeach
                </div>
            @endif

            <div class="admin-float-button" onclick="openThemeModal()">+</div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un thème (le même que dans dashboard) -->
<div id="themeModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeThemeModal()">&times;</span>
        <h2 style="color: blanchedalmond;font-size: 30px">Add new theme</h2>
        <form action="{{ route('themes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="theme_name"> Theme name</label>
                <input type="text" id="theme_name" name="name" required style="color: black">
            </div>
            <div class="form-group">
                <label for="theme_icon">Icon name</label>
                <input type="text" id="theme_icon" name="icon" required style="color: black">
            </div>
            <button type="submit" class="submit-btn">Add</button>
        </form>
    </div>
</div>

<style>
.container30{
    height: 100vh;
    background: black;
}
.main-container2{
    background: black;
}
.themes-list {
    padding: 20px;
    flex-direction: row-gap: 20px;
}

.themes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.theme-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.theme-icon {
    font-size: 2em;
    color: #4a5568;
}

.theme-info {
    flex: 1;
}

.theme-info h3 {
    margin: 0 0 10px 0;
    color: #2d3748;
}

.theme-info p {
    margin: 5px 0;
    color: #718096;
}
</style>

<style>

    .theme-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: 15px;
        width: 100%;
    }

    .theme-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
</style>


<script>
    function openThemeModal() {
        document.getElementById('themeModal').style.display = 'block';
    }

    function closeThemeModal() {
        document.getElementById('themeModal').style.display = 'none';
    }
</script>
@endsection
