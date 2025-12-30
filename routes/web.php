<?php

use App\Livewire\AboutUs;
use App\Livewire\FeedBackPage;
use App\Livewire\FeedbackPengaduanPage;
use App\Livewire\FullScreenVideo;
use App\Livewire\GuestBookPage;
use App\Livewire\HomePage;
use App\Livewire\PengaduanPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/buku-tamu', GuestBookPage::class)->name('guest-book');
Route::get('/buku-tamu/feedback', FeedBackPage ::class)->name('guest-book.feedback');
Route::get('/pengaduan', PengaduanPage ::class)->name('pengaduan');
Route::get('/pengaduan/feedback', FeedbackPengaduanPage ::class)->name('pengaduan.feedback');
Route::get('/slideshows', FullScreenVideo::class)->name('slideshow.fullscreen');

Route::get('/tentang-kami', AboutUs ::class)->name('about-us');;
