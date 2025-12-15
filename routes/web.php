<?php

use Illuminate\Support\Facades\Route;
//uses public
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MovieController;
use App\Http\Controllers\Public\SerieController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\GenreController;
use App\Http\Controllers\Public\AuthController as PublicAuthController;

//uses admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EpisodePlayLinkController;
use App\Http\Controllers\Admin\MoviePlayLinkController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ExploreController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\NetworkController as AdminNetworkController;
use App\Http\Controllers\Admin\SerieController as AdminSerieController;
use App\Http\Controllers\Admin\TmdbController as AdminTmdbController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PremiumCodeControllerr;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TvChannelController;
use App\Http\Controllers\Admin\TvChannelLinkController;

Route::get('/filme/{id}', [MovieController::class, 'showByTmdb'])->name('movie.by.tmdb');
Route::get('/serie/{tmdbId}', [SerieController::class, 'showByTmdb'])->name('serie.by.tmdb');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/app/download', [HomeController::class, 'appDownload'])->name('app.download');
Route::get('/filmes/{slug}', [MovieController::class, 'show'])->name('movie.show');
Route::get('/series/{slug}', [SerieController::class, 'show'])->name('serie.show');
Route::get('/filmes', [MovieController::class, 'index'])->name('movie.index');
Route::get('/series', [SerieController::class, 'index'])->name('serie.index');
Route::get('/pesquisa', [SearchController::class, 'index'])->name('search.index');
Route::get('/categorias/{slug}', [GenreController::class, 'show'])->name('genres.show');


// Rotas admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'loginProcess'])->name('admin.login.process');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['admin'])->prefix('dashboard')->name('admin.')->group(function () {
    // Dashboard principal
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/{slider}', [DashboardController::class, 'deleteSlider'])->name('deleteSlider');
    Route::get('/genres/list', [DashboardController::class, 'listGenres'])->name('genres.list');
    Route::get('/networks/list', [DashboardController::class, 'listNetworks'])->name('networks.list');

    Route::prefix('tmdb')->name('tmdb.')->group(function () {
        Route::get('/', [AdminTmdbController::class, 'index'])->name('index');  // /dashboard/tmdb
        Route::get('/search', [AdminTmdbController::class, 'search'])->name('search'); // /dashboard/tmdb/search
        Route::post('/import', [AdminTmdbController::class, 'import'])->name('import'); // rota AJAX POST
        Route::get('/import-serie', [AdminTmdbController::class, 'importSerie'])->name('importSerie');
        Route::get('/get-seasons', [AdminTmdbController::class, 'getSeasons'])->name('getSeasons');
        Route::get('/import-seasons', [AdminTmdbController::class, 'importSeasons'])->name('importSeasons');
        Route::get('/import-episodes', [AdminTmdbController::class, 'importEpisodes'])->name('importEpisodes');
        Route::get('/import-episodes-all', [AdminTmdbController::class, 'importAllEpisodes'])->name('importEpisodesAll');
    });

    // Grupo de rotas de usuários
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');           // /dashboard/users
        Route::get('/{id}', [AdminUserController::class, 'show'])->name('show');         // /dashboard/users/{id}
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');    // /dashboard/users/{id}/edit
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');     // /dashboard/users/{id} (PUT)
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('delete'); // /dashboard/users/{id} (DELETE)
        Route::get('/ajax', [AdminUserController::class, 'ajax'])->name('ajax');
    });

    // Grupo de rotas de filmes
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', [AdminMovieController::class, 'index'])->name('index');           // /dashboard/movies
        Route::get('/{id}', [AdminMovieController::class, 'show'])->name('show');         // /dashboard/movies/{id}
        Route::get('/{id}/edit', [AdminMovieController::class, 'edit'])->name('edit');    // /dashboard/movies/{id}/edit
        Route::put('/{id}', [AdminMovieController::class, 'update'])->name('update');     // /dashboard/movies/{id} (PUT)
        Route::delete('/{id}', [AdminMovieController::class, 'destroy'])->name('delete'); // /dashboard/movies/{id} (DELETE)
        Route::get('/{movie}/links', [AdminMovieController::class, 'linkManager'])->name('links'); // /dashboard/movies/{id}/links
    });

    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/{movie}/create', [MoviePlayLinkController::class, 'create'])->name('create'); // /dashboard/links/{movie}/create
        Route::post('/{movie}', [MoviePlayLinkController::class, 'store'])->name('store'); // /dashboard/links/{movie}
        Route::get('/{link}/edit', [MoviePlayLinkController::class, 'edit'])->name('edit'); // /dashboard/links/{movie}/edit
        Route::put('/{link}', [MoviePlayLinkController::class, 'update'])->name('update'); // /dashboard/links/{movie}
        Route::delete('/{link}', [MoviePlayLinkController::class, 'destroy'])->name('destroy'); // /dashboard/links/{movie}
    });

    // Grupo de rotas de canais de TV
    Route::prefix('tv')->name('tv.')->group(function () {
        Route::get('/', [TvChannelController::class, 'index'])->name('index');             // /dashboard/tv
        Route::get('/create', [TvChannelController::class, 'create'])->name('create');     // /dashboard/tv/create
        Route::post('/', [TvChannelController::class, 'store'])->name('store');            // /dashboard/tv (POST)
        Route::get('/{channel}', [TvChannelController::class, 'edit'])->name('edit');      // /dashboard/tv/{channel}
        Route::put('/{channel}', [TvChannelController::class, 'update'])->name('update');  // /dashboard/tv/{channel} (PUT)
        Route::delete('/{channel}', [TvChannelController::class, 'destroy'])->name('delete'); // /dashboard/tv/{channel} (DELETE)
        Route::get('/{channel}/links', [TvChannelController::class, 'edit'])->name('links'); // Gerenciar links do canal
    });

    // Grupo de rotas de links de TV
    Route::prefix('tv-links')->name('tv-links.')->group(function () {
        Route::get('/{channel}/create', [TvChannelLinkController::class, 'create'])->name('create'); // /dashboard/tv-links/{channel}/create
        Route::post('/{channel}', [TvChannelLinkController::class, 'store'])->name('store');         // /dashboard/tv-links/{channel}
        Route::get('/{link}/edit', [TvChannelLinkController::class, 'edit'])->name('edit');         // /dashboard/tv-links/{link}/edit
        Route::put('/{link}', [TvChannelLinkController::class, 'update'])->name('update');          // /dashboard/tv-links/{link} (PUT)
        Route::delete('/{link}', [TvChannelLinkController::class, 'destroy'])->name('destroy');     // /dashboard/tv-links/{link} (DELETE)
    });

    // Grupo de rotas de séries
    Route::prefix('series')->name('series.')->group(function () {
        Route::get('/', [AdminSerieController::class, 'index'])->name('index');           // /dashboard/series
        Route::get('/{id}', [AdminSerieController::class, 'show'])->name('show');         // /dashboard/series/{id}
        Route::get('/{id}/edit', [AdminSerieController::class, 'edit'])->name('edit');    // /dashboard/series/{id}/edit
        Route::put('/{id}', [AdminSerieController::class, 'update'])->name('update');     // /dashboard/series/{id} (PUT)
        Route::delete('/{id}', [AdminSerieController::class, 'destroy'])->name('delete'); // /dashboard/series/{id} (DELETE)

        Route::get('/{serie}/seasons', [AdminSerieController::class, 'manageSeasons'])->name('seasons');
        Route::get('/{serie}/seasons/{season}/episodes', [AdminSerieController::class, 'manageEpisodes'])->name('episodes');
        Route::delete('/{serie}/seasons/{season}', [AdminSerieController::class, 'deleteSeason'])->name('deleteSeason');
        Route::delete('/{serie}/seasons/{season}/episodes/{episode}', [AdminSerieController::class, 'deleteEpisode'])->name('deleteEpisode');
    });

    Route::prefix('episodes')->name('episodes.')->group(function () {
        Route::get('/{episode}/links', [EpisodePlayLinkController::class, 'index'])->name('links'); // /dashboard/episodes/{id}/links
        Route::get('/{episode}/links/create', [EpisodePlayLinkController::class, 'create'])->name('createLink'); // /dashboard/episodes/{id}/links/create
        Route::post('/{episode}/links/create', [EpisodePlayLinkController::class, 'store'])->name('storeLink'); // /dashboard/episodes/{id}/links/create
        Route::get('/links/{link}/edit', [EpisodePlayLinkController::class, 'edit'])->name('editLink'); // /dashboard/episodes/{id}/links/{link}/edit')
        Route::put('/links/{link}', [EpisodePlayLinkController::class, 'update'])->name('updateLink'); // /dashboard/episodes/{id}/links/{link}/edit')
        Route::delete('/links/{link}', [EpisodePlayLinkController::class, 'destroy'])->name('destroyLink'); // /dashboard/episodes/{id}/links/{link}/edit')
    });

    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/series/{serie}/bulk-links', [EpisodePlayLinkController::class, 'bulkLinks'])->name('bulkLinks');
        Route::post('/series/{serie}/bulk-links', [EpisodePlayLinkController::class, 'bulkStore'])->name('bulkStore');
    });

    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/create', [SliderController::class, 'store'])->name('store');
        Route::get('/search', [SliderController::class, 'search'])->name('search');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('delete');
    });

    Route::prefix('sections')->name('sections.')->group(function () {
        Route::get('/', [HomeSectionController::class, 'index'])->name('index');
        Route::get('/create', [HomeSectionController::class, 'create'])->name('create');
        Route::post('/create', [HomeSectionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [HomeSectionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HomeSectionController::class, 'update'])->name('update');
        Route::delete('/{section}', [HomeSectionController::class, 'destroy'])->name('delete');
    });

    Route::prefix('networks')->name('networks.')->group(function () {
        Route::get('/', [AdminNetworkController::class, 'index'])->name('index');
        Route::get('/create', [AdminNetworkController::class, 'create'])->name('create');
        Route::post('/create', [AdminNetworkController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminNetworkController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminNetworkController::class, 'update'])->name('update');
        Route::delete('/{network}', [AdminNetworkController::class, 'destroy'])->name('delete');
    });

    Route::prefix('explore')->name('explore.')->group(function () {
        Route::get('/', [ExploreController::class, 'index'])->name('index');
        Route::get('/create', [ExploreController::class, 'create'])->name('create');
        Route::post('/create', [ExploreController::class, 'store'])->name('store');
        Route::get('/{section}/edit', [ExploreController::class, 'edit'])->name('edit');
        Route::put('/{section}', [ExploreController::class, 'update'])->name('update');
        Route::delete('/{section}', [ExploreController::class, 'destroy'])->name('delete');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/create', [AdminNotificationController::class, 'create'])->name('create');
        Route::post('/send', [AdminNotificationController::class, 'send'])->name('send');
    });

    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('create');
        Route::post('/create', [SubscriptionController::class, 'store'])->name('store');
        Route::get('/{plan}/edit', [SubscriptionController::class, 'edit'])->name('edit');
        Route::put('/{plan}', [SubscriptionController::class, 'update'])->name('update');
        Route::delete('/{plan}', [SubscriptionController::class, 'destroy'])->name('delete');
    });

    Route::prefix('coupans')->name('coupans.')->group(function () {
        Route::get('/', [PremiumCodeControllerr::class, 'index'])->name('index');
        Route::get('/create', [PremiumCodeControllerr::class, 'create'])->name('create');
        Route::post('/create', [PremiumCodeControllerr::class, 'store'])->name('store');
        Route::get('/{coupan}/edit', [PremiumCodeControllerr::class, 'edit'])->name('edit');
        Route::put('/{coupan}', [PremiumCodeControllerr::class, 'update'])->name('update');
        Route::delete('/{coupan}', [PremiumCodeControllerr::class, 'destroy'])->name('delete');
    });
});
