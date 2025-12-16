<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Sign in</title>
<style>
  :root{ --brown:#8B4513;--light-brown:#A0642B;--cream:#fff7f0;--muted:#f4f4f6;--ink:#2b2b2b }
  body{margin:0;background:linear-gradient(180deg,#f8efe6,#fff);font-family:Arial,Helvetica,sans-serif;color:var(--ink)}
  header{ background:var(--brown); padding:14px 0; position:sticky; top:0; z-index:2 }
  .topbar .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px }
  .topbar .brand{ font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; font-size:16px }
  .brand .logo{ width:22px; height:22px; object-fit:contain }
  .top-links{ margin-left:auto; display:flex; gap:20px; align-items:center }
  .top-links a{ color:#fff; text-decoration:none; font-size:15px; transition:opacity .3s }
  .top-links a:hover{ opacity:.85 }
  .layout{max-width:1100px;margin:24px auto;display:grid;grid-template-columns:1fr 420px;gap:20px;padding:0 16px}
  .panel{background:#fff;border-radius:14px;box-shadow:0 14px 24px rgba(139,69,19,.18);overflow:hidden;border:1px solid #ecd9c7}
  .slider{position:relative;height:400px;background:#e9dccf;overflow:hidden}
  .slider::before{content:"";position:absolute;left:0;right:0;top:0;bottom:0;background:linear-gradient(0deg,rgba(0,0,0,.35),rgba(0,0,0,0) 50%);pointer-events:none}
  .slide{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transform:scale(1.06);transition:opacity .8s ease, transform 3.5s ease}
  .slide.show{opacity:1;transform:scale(1)}
  .caption{position:absolute;left:18px;bottom:18px;color:#fff;background:rgba(0,0,0,.35);padding:10px 12px;border-radius:10px;backdrop-filter:blur(6px)}
  .caption .cap-title{font-weight:700;font-size:16px}
  .caption .cap-sub{font-size:12px;opacity:.9}
  .dots{position:absolute;right:18px;bottom:18px;display:flex;gap:6px}
  .dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.6);cursor:pointer;transition:transform .2s,background .2s}
  .dot.active{background:#fff;transform:scale(1.2)}
  .form{padding:24px}
  h1{margin:0 0 8px;color:var(--brown);font-size:24px}
  .sub{color:#8B6F47;font-size:13px;margin-bottom:8px}
  .group{margin:10px 0}
  .field{width:100%;padding:12px;border:1px solid #d9c2ae;border-radius:10px;background:#fff}
  .field:focus{outline:none;box-shadow:0 0 0 2px rgba(139,69,19,.25)}
  .btn{width:100%;margin-top:12px;padding:12px;border:none;border-radius:10px;background:var(--brown);color:#fff;font-weight:700;cursor:pointer;transition:transform .18s, box-shadow .18s}
  .btn:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(139,69,19,.25)}
  .links{margin-top:12px;display:flex;justify-content:space-between}
  a{color:var(--brown);text-decoration:none}
  .error{color:#b00020;margin-bottom:8px}
</style>
</head>
<body>
<header class="topbar"><div class="nav-inner"><a href="{{ route('home') }}" style="text-decoration:none"><div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div></a><nav class="top-links"><a href="{{ route('home') }}">Home</a><a href="{{ route('book') }}">Booking</a></nav></div></header>
<div class="layout">
  <div class="panel">
    <div class="slider" id="slider">
      <img class="slide show" src="/StandardRoom.png" alt="Standard" />
      <img class="slide" src="/Delux.png" alt="Deluxe" />    
      <img class="slide" src="/Executive.png" alt="Executive" />
      <img class="slide" src="/Premium.png" alt="Premium" /> 
      <img class="slide" src="/Family.png" alt="Family" />   
      <img class="slide" src="/Penthouse.png" alt="Penthouse" />
      <div class="caption"><div class="cap-title" id="capTitle"></div><div class="cap-sub" id="capSub">Discover comfort</div></div>
      <div class="dots" id="dots"></div>
    </div>
  </div>
  <div class="panel form">
    <h1>Sign in</h1>
    <div class="sub">Access your bookings and fast checkout</div>
    @if($errors->any())<div class="error">{{ $errors->first('email') ?: 'Invalid credentials' }}</div>@endif
    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="group"><input class="field" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required /></div>
      <div class="group"><input class="field" name="password" type="password" placeholder="Password" required /></div>
      <button class="btn" type="submit">Sign in</button>
    </form>
    <div class="links"><a href="{{ route('register') }}">Create account</a><a href="{{ route('home') }}">Back to Home</a></div>
  </div>
</div>
<script>
  (function(){
    var idx=0; var slides=[].slice.call(document.querySelectorAll('.slide'));
    var dotsWrap=document.getElementById('dots'); var capTitle=document.getElementById('capTitle'); var capSub=document.getElementById('capSub');
    var dots=[]; slides.forEach(function(_,i){ var s=document.createElement('span'); s.className='dot'; s.addEventListener('click',function(){ show(i); }); dotsWrap.appendChild(s); dots.push(s); });
    function show(i){ if(!slides.length) return; slides[idx].classList.remove('show'); if(dots[idx]) dots[idx].classList.remove('active'); idx=i%slides.length; slides[idx].classList.add('show'); if(dots[idx]) dots[idx].classList.add('active'); if(capTitle) capTitle.textContent=slides[idx].getAttribute('alt')||'Room'; }
    show(0);
    setInterval(function(){ show(idx+1); }, 3500);
  })();
</script>
</body>
</html>
