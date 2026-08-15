@php
  /** @var \App\Models\SiteSetting $siteSettings */
  $siteSettings ??= \App\Models\SiteSetting::current();
  $meta = $siteSettings->metaFor($seoPage ?? 'home');
  $title = $seoTitle ?? $meta['title'];
  $description = $seoDescription ?? $meta['description'];
  $ogTitle = $siteSettings->og_title ?: $title;
  $ogDescription = $siteSettings->og_description ?: $description;
  $ogImage = $siteSettings->ogImageUrl();
  $canonical = $canonicalUrl ?? $siteSettings->canonicalUrl();
@endphp
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="{{ $siteSettings->theme_color ?: '#1a1d24' }}" />
<meta name="description" content="{{ $description }}" />
@if(filled($meta['keywords']))
<meta name="keywords" content="{{ $meta['keywords'] }}" />
@endif
<meta name="robots" content="{{ $meta['robots'] }}" />
<link rel="canonical" href="{{ $canonical }}" />
<title>{{ $title }}</title>
<link rel="icon" href="{{ $siteSettings->faviconUrl() }}" />

<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:title" content="{{ $ogTitle }}" />
<meta property="og:description" content="{{ $ogDescription }}" />
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}" />
@endif
<meta property="og:site_name" content="{{ $siteSettings->site_name }}" />

<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}" />
@if(filled($siteSettings->twitter_site))
<meta name="twitter:site" content="{{ $siteSettings->twitter_site }}" />
@endif
<meta name="twitter:title" content="{{ $ogTitle }}" />
<meta name="twitter:description" content="{{ $ogDescription }}" />
@if($ogImage)
<meta name="twitter:image" content="{{ $ogImage }}" />
@endif

@if(filled($siteSettings->google_site_verification))
<meta name="google-site-verification" content="{{ $siteSettings->google_site_verification }}" />
@endif

@if(filled($siteSettings->analytics_measurement_id))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings->analytics_measurement_id }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', @json($siteSettings->analytics_measurement_id));
</script>
@endif

<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Event',
  'name' => $siteSettings->site_name,
  'description' => $siteSettings->meta_description,
  'startDate' => '2026-10-10',
  'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
  'eventStatus' => 'https://schema.org/EventScheduled',
  'location' => [
    '@type' => 'Place',
    'name' => 'University of Global Village',
    'address' => [
      '@type' => 'PostalAddress',
      'addressLocality' => 'Barishal',
      'addressCountry' => 'BD',
    ],
  ],
  'organizer' => [
    '@type' => 'Organization',
    'name' => 'UGV Programming Club',
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />
