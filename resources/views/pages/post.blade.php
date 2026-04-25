@extends('layouts.site')

@section('title', $post->title.' | CyberTechna Solutions')

@section('content')
    <section class="section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9">
                    <div class="frame-card mb-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                            <span class="eyebrow">Insight publicado</span>
                            <span class="soft-label">{{ $post->status === 'published' ? 'Publicado' : 'Borrador visible solo para propietario' }}</span>
                        </div>

                        <h1 class="display-5 text-white mb-3">{{ $post->title }}</h1>
                        <p class="hero-copy mb-4">{{ $post->excerpt }}</p>

                        <div class="d-flex flex-wrap gap-3 muted mb-0">
                            <span>Fecha: {{ optional($post->published_at ?? $post->created_at)->format('d/m/Y H:i') }}</span>
                            <span>Autor: {{ $post->author?->name ?? 'CyberTechna Solutions' }}</span>
                        </div>
                    </div>

                    <article class="frame-card article-body mb-4">{!! nl2br(e($post->content)) !!}</article>

                    <div class="owner-banner">
                        <div>
                            <strong class="d-block text-white mb-1">Necesitas una evaluacion similar para tu empresa?</strong>
                            <span class="form-note">CyberTechna Solutions puede convertir este tipo de hallazgos en un plan accionable para tu contexto.</span>
                        </div>
                        <a href="{{ route('home') }}#contacto" class="btn btn-signal">Hablar con nosotros</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection