<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Language</title>
<style>body{margin:0;background:#f4f4f6;font-family:Arial,Helvetica,sans-serif}.nav{background:#8B4513;color:#fff;padding:12px 16px}.hero{background:linear-gradient(135deg,#8B6F47,#8B4513);color:#fff;text-align:center;padding:60px 20px;animation:fadeIn 600ms ease}.wrap{max-width:900px;margin:20px auto;background:#fff;padding:20px;border-radius:10px;box-shadow:0 10px 24px rgba(0,0,0,0.08);animation:fadeUp 400ms ease}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px}.card{border:1px solid #e0d7d0;border-radius:8px;padding:12px;color:#8B4513;text-align:center;box-shadow:0 6px 16px rgba(0,0,0,0.06);transition:transform .2s}.card:hover{transform:translateY(-2px)}@keyframes fadeIn{from{opacity:0}to{opacity:1}}@keyframes fadeUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}</style>
</head>
<body>
<div class="nav"><a href="{{ route('home') }}" style="color:#fff;text-decoration:none">Home</a></div>
<div class="hero"><h1>Language</h1><p>Select your preferred language</p></div>
<div class="wrap">
  <div class="grid">
    <div class="card">English</div>
    <div class="card">Filipino</div>
    <div class="card">Cebuano</div>
    <div class="card">中文</div>
    <div class="card">한국어</div>
    <div class="card">日本語</div>
    <div class="card">Español</div>
    <div class="card">Français</div>
  </div>
  <p style="margin-top:12px">Language selection is decorative in this demo. Content remains in English.</p>
</div>
</body>
</html>
