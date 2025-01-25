{{--
@extends('welcome')

@section('title', 'Save')

@section('content')



  <div class="container12">
       <h1 >My Saved Articles</h1>

       <div class="saved-posts">
          @forelse ($savedArticles as $savedArticle)
             <div class="post">
                  <div class="post-header">
                      <div class="post-meta">
                           <strong>{{ $savedArticle->article->creator->name }}</strong>
                           <div>Sauvegardé le {{ $savedArticle->created_at->format('d/m/Y') }}</div>
                      </div>
                  </div>
                    @if($savedArticle->article->image)
                        <div>
                           <img src="{{ $savedArticle->article->image }}"  id="imageARTICLE" alt="Article Image">
                        </div>
                   @endif
                   <h3>{{ $savedArticle->article->title }}</h3>
                    <p id="contentARTICLE">{{ $savedArticle->article->content }}</p>

                    <div class="post-options">
                      <form action="{{ route('articles.unsave', $savedArticle->article->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="unsave-button">
                            <i class="fas fa-bookmark"></i> Retirer des sauvegardes
                        </button>
                      </form>
                 </div>
            </div>
            @empty
            <p id="Message">Vous n'avez pas encore d'articles sauvegardés.</p>
         @endforelse
    </div>


@endsection
--}}
@extends('welcome')

@section('title', 'Save')

@section('content')
<div class="container12">
    <h1>My Saved Articles</h1>
    <div class="saved-articles">
        @forelse ($savedArticles as $savedArticle)
        <div class="article-card">
            <div class="article-image">
                <img src="{{ $savedArticle->article->image }}" alt="Article Image">
            </div>
            <div class="article-details">
                <h3>{{ $savedArticle->article->title }}</h3>
                <p class="saved-date">Sauvegardé le {{ $savedArticle->created_at->format('d/m/Y') }}</p>
                <p class="article-excerpt">{{ Str::limit($savedArticle->article->content, 100) }}</p>
                <button class="read-more" data-article-id="{{ $savedArticle->article->id }}">Lire plus</button>
                <form action="{{ route('articles.unsave', $savedArticle->article->id) }}" method="POST" class="unsave-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="unsave-button">
                        <i class='bx bxs-bookmark-minus'></i> Retirer des sauvegardes
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p id="Message">Vous n'avez pas encore d'articles sauvegardés.</p>
        @endforelse
    </div>
</div>

<div class="modal2" id="article-modal">
    <div class="modal-content2">
        <span class="close-modal">&times;</span>
        <h2 class="article-title"></h2>
        <p class="article-content"></p>
    </div>
</div>

<script>
    document.querySelectorAll('.read-more').forEach(button => {
    button.addEventListener('click', () => {
        const articleId = button.dataset.articleId;
        const article = @json($savedArticles).find(a => a.article.id == articleId);

        document.querySelector('.article-title').textContent = article.article.title;
        document.querySelector('.article-content').textContent = article.article.content;

        const modal = document.getElementById('article-modal');
        modal.style.display = 'block';

        document.querySelector('.close-modal').addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });
});
</script>
@endsection
