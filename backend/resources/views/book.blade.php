<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Booking - Hotelbase</title>
<style>
  :root{ --brown:#8B4513;--light-brown:#8B6F47;--muted:#f4f4f6;--card:#fff; --radius:8px;font-family:Arial,Helvetica,sans-serif;color:#333; }
  *{box-sizing:border-box}
  body{margin:0;background:var(--muted);padding:0}
  header{ background:var(--brown); padding:0; margin:0; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
  .nav-indicator{display:none}
  .topbar{ background:var(--brown); padding:14px 0; }
  .topbar .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px; }
  .topbar .brand{ font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; font-size:16px; }
  .top-links{ margin-left:auto; display:flex; gap:50px; align-items:center; }
  .top-links a{ color:#fff; text-decoration:none; font-size:15px; transition:opacity 0.3s; }
  .top-links a:hover{ opacity:0.8; }
  .top-links a.active{ font-weight:600; background:#6b3410; padding:12px 16px; border-radius:6px; }
  main{ padding:36px 16px; }
  .brand{display:flex;align-items:center;gap:10px;font-weight:700;color:var(--brown)}
  .container{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 360px;gap:20px}
  .card{background:var(--card);border-radius:var(--radius);padding:22px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
  .steps{display:flex;gap:10px;margin-bottom:18px}
  .step{flex:1;padding:10px;border-radius:6px;background:#fff;border:1px solid #efefef;font-size:13px;display:flex;align-items:center;gap:10px}
  .step.active{background:linear-gradient(90deg,var(--light-brown),var(--brown));color:#fff;border-color:transparent}
  h2{font-size:18px;margin-bottom:12px}
  label{display:block;font-size:13px;margin:8px 0 6px}
  input[type=text], input[type=date], input[type=email], input[type=tel], select, textarea { width:100%;padding:10px;border:1px solid #e2e2e2;border-radius:6px;font-size:14px;background:#fff; }
  .rows{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
  .rooms-list{display:flex;flex-direction:column;gap:12px;margin-top:12px}
  .room-item{display:flex;gap:12px;align-items:center;padding:10px;border-radius:8px;border:1px solid #eee}
  .room-item img{width:84px;height:56px;object-fit:cover;border-radius:6px;background:linear-gradient(135deg,var(--light-brown),#c89b7b)}
  .room-meta{flex:1}
  .room-meta h4{margin:0 0 6px;font-size:15px}
  .room-meta p{margin:0;font-size:13px;color:#666}
  .select-room{background:transparent;border:1px solid var(--brown);color:var(--brown);padding:8px 10px;border-radius:6px;cursor:pointer}
  .summary{position:sticky;top:24px}
  .summary .small{font-size:13px;color:#666;margin-bottom:8px}
  .price{font-weight:700;color:var(--brown);font-size:20px}
  .btn{background:var(--brown);color:#fff;border:none;padding:12px 18px;border-radius:8px;cursor:pointer;font-weight:600}
  .btn.secondary{background:#fff;color:var(--brown);border:1px solid #e0d7d0}
  .muted{color:#777;font-size:13px}
  .split{display:flex;gap:10px}
  .hidden{display:none}
  .info-box{background:#fff8f2;border:1px solid #f0d8c7;padding:10px;border-radius:8px;color:#5a3b23;font-size:14px}
  .copy-btn{background:transparent;border:1px solid var(--brown);color:var(--brown);padding:6px 10px;border-radius:6px;cursor:pointer;font-weight:600}
  @media(max-width:600px){.topbar .nav-inner{padding:0 12px} .top-links a{padding:6px 8px;font-size:13px} .rows{grid-template-columns:1fr}}
</style>
</head>
<body>
<header>
  <div class="nav-indicator" aria-hidden></div>
  <div class="topbar">
    <div class="nav-inner">
      <a href="{{ route('home') }}" style="text-decoration: none;"><div class="brand">🏨 HotelEase</div></a>
      <nav class="top-links" aria-label="Main">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('book') }}" class="active">Booking</a>
      </nav>
    </div>
  </div>
</header>

<main class="container">
  <section>
    <div class="card">
      <div class="steps" aria-hidden>
        <div id="stepLabel1" class="step active">1. Dates & Room</div>
        <div id="stepLabel2" class="step">2. Guest Details</div>
        <div id="stepLabel3" class="step">3. Payment</div>
      </div>

      <div id="step1">
        <h2>Step 1: Choose Your Stay Details</h2>
        <div class="rows">
          <div>
            <label for="checkin">Check-in Date</label>
            <input id="checkin" type="date" />
          </div>
          <div>
            <label for="checkout">Check-out Date</label>
            <input id="checkout" type="date" />
          </div>
        </div>

        <div style="margin-top:12px">
          <label for="guests">Number of Guests</label>
          <select id="guests">
            <option>1 Guest</option>
            <option>2 Guests</option>
            <option>3 Guests</option>
            <option>4 Guests</option>
          </select>
        </div>

        <div style="margin-top:14px;display:flex;align-items:center;gap:12px;justify-content:space-between">
          <label style="font-weight:600;margin:0">Available Rooms</label>
          <div class="muted" id="availCount">Showing available rooms</div>
        </div>

        <div class="rooms-list" id="roomsList"></div>

        <div style="display:flex;justify-content:space-between;margin-top:18px">
          <button class="btn secondary" onclick="prevStep()" disabled>Back</button>
          <button class="btn" onclick="nextFromStep1()">Select & Continue</button>
        </div>
      </div>

      <div id="step2" class="hidden">
        <h2>Step 2: Guest Information</h2>
        <div class="rows">
          <div>
            <label for="fullname">Full Name</label>
            <input id="fullname" type="text" placeholder="Enter your full name" />
          </div>
          <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" placeholder="you@mail.com" />
          </div>
        </div>
        <div style="margin-top:12px">
          <label for="phone">Phone Number</label>
          <input id="phone" type="tel" placeholder="63+ 998 765 4321" />
        </div>
        <div style="margin-top:12px">
          <label for="requests">Special Requests</label>
          <textarea id="requests" rows="3" placeholder="e.g., late check-in, extra pillows"></textarea>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:18px">
          <button class="btn secondary" onclick="goTo(1)">Back</button>
          <button class="btn" onclick="validateGuest()">Continue to Payment</button>
        </div>
      </div>

      <div id="step3" class="hidden">
        <h2>Step 3: Secure Payment</h2>
        <label>Payment Method</label>
        <div style="display:flex;gap:10px;margin:8px 0;flex-wrap:wrap">
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="card" checked /> Credit/Debit Card</label>
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="arrival" /> Pay on Arrival</label>
          <label style="display:flex;align-items:center;gap:8px"><input type="radio" name="pm" value="ewallet" /> E-Wallet (GCash / PayMaya)</label>
        </div>
        <div id="cardFields">
          <div style="margin-top:8px">
            <label for="cardname">Cardholder Name</label>
            <input id="cardname" type="text" placeholder="Name on card" />
          </div>
          <div class="rows" style="margin-top:8px">
            <div>
              <label for="cardnumber">Card Number</label>
              <input id="cardnumber" type="text" placeholder="1234 5678 9012 3456" maxlength="19" />
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
              <input id="expiry" type="text" placeholder="MM/YY" />
              <input id="cvv" type="text" placeholder="CVV" maxlength="4" />
            </div>
          </div>
        </div>
        <div id="ewalletFields" class="hidden" style="margin-top:12px">
          <div class="info-box">
            <strong>Send your e-wallet payment to:</strong>
            <div style="margin-top:8px;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
              <div>
                <div class="muted">Account Name</div>
                <div style="font-weight:700">HotelEase</div>
              </div>
              <div>
                <div class="muted">Mobile / E-Wallet Number</div>
                <div style="font-weight:700" id="ewalletNumber">09978606886</div>
              </div>
              <div>
                <button class="copy-btn" onclick="copyPaymentInfo()">Copy Number</button>
              </div>
            </div>
            <div style="margin-top:8px" class="muted">After sending the payment, please keep the transaction reference and press "Confirm & Book Now". You will receive a confirmation email once the payment is verified.</div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:18px;align-items:center">
          <button class="btn secondary" onclick="goTo(2)">Back</button>
          <button class="btn" onclick="confirmBooking()">Confirm & Book Now</button>
        </div>
      </div>
    </div>
  </section>

  <aside class="summary">
    <div class="card">
      <div class="small">Booking Summary</div>
      <div style="display:flex;gap:12px;align-items:center">
        <img id="summaryImage" alt="Room" src="" style="width:84px;height:64px;border-radius:8px;object-fit:cover;background:linear-gradient(135deg,var(--light-brown),#c89b7b)" />
        <div>
          <div id="summaryRoom" style="font-weight:700">—</div>
          <div class="muted" id="summaryDates">Select dates</div>
        </div>
      </div>
      <div style="margin-top:12px">
        <div style="display:flex;justify-content:space-between"><div class="muted">Nights</div><div id="nights">0</div></div>
        <div style="display:flex;justify-content:space-between"><div class="muted">Room Price</div><div id="roomPrice">₱0</div></div>
        <div style="display:flex;justify-content:space-between"><div class="muted">Taxes & Fees</div><div id="taxes">₱0</div></div>
        <hr style="border:none;border-top:1px dashed #eee;margin:12px 0">
        <div style="display:flex;justify-content:space-between"><div style="font-weight:700">Total</div><div class="price" id="total">₱0</div></div>
      </div>
      <div style="margin-top:14px;text-align:center">
        <button id="proceedBtn" class="btn" onclick="proceedToPayment()" title="Complete steps 1 & 2 to proceed">Proceed to Payment</button>
      </div>
    </div>
    <div style="height:14px"></div>
    <div class="card" style="text-align:center">
      <div style="font-weight:700;margin-bottom:8px">Need help?</div>
      <div class="muted">Call: +1 (555) 123-4567<br/>or email: info@hotelease.com</div>
    </div>
  </aside>
</main>

<footer id="contact" style="background-color:#8B6F47;color:white;padding:40px 20px;text-align:center">
  <div class="footer-content" style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:30px;text-align:left">
    <div class="footer-section">
      <h4>🏨 HotelEase</h4>
      <p>Experience comfort and convenience at Hotelbase.</p>
    </div>
    <div class="footer-section">
      <h4>Quick Links</h4>
      <a href="{{ route('home') }}" style="color:#f0f0f0">Home</a>
      <a href="{{ route('services') }}" style="color:#f0f0f0">Services</a>
    </div>
    <div class="footer-section" id="Contact">
      <h4>Contact Info</h4>
      <p>📍 HotelEase, Cebu IT Park, Abad St, Brgy Apas, Cebu City, 6000 Cebu, Philippines.</p>
      <p>📞 +1 (555) 123-4567</p>
      <p>📧 info@hotelease.com</p>
    </div>
    <div class="footer-section">
      <h4>Follow Us</h4>
      <div class="social-icons" style="display:flex;gap:15px;margin-top:15px">
        <a href="#" title="Facebook" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">f</a>
        <a href="#" title="Twitter" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">𝕏</a>
        <a href="#" title="Instagram" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">📷</a>
        <a href="#" title="LinkedIn" style="display:inline-block;width:30px;height:30px;background-color:#6b5a42;border-radius:50%;text-align:center;line-height:30px;color:#fff;text-decoration:none">in</a>
      </div>
    </div>
  </div>
  <div class="footer-bottom" style="margin-top:30px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.2);text-align:center;font-size:12px">
    <p>&copy; 2025 Hotelbase. All rights reserved.</p>
  </div>
</footer>

<script>
const rooms = [
  {id:'Standard Room',price:1500,desc:'Comfortable room for 1-2 guests',image:'/StandardRoom.png'},
  {id:'Deluxe Room',price:1760,desc:'Premium furnishings & city view',image:'/Delux.png'},
  {id:'Executive Suite',price:6000,desc:'Separate living area & premium amenities',image:'/Executive.png'},
  {id:'Premium Suite',price:3700,desc:'Panoramic views & exclusive services',image:'/Premium.png'},
  {id:'Family Room',price:1100,desc:'Spacious rooms for families',image:'/Family.png'},
  {id:'Penthouse Suite',price:9800,desc:'Top-floor luxury & concierge',image:'/Penthouse.png'}
];
let state = {step:1,selected: null,checkin:null,checkout:null,guests:1,guestInfo:{},pm:'card'};
function $(s){return document.querySelector(s)}
function populateRooms(){ const list = $('#roomsList'); list.innerHTML=''; rooms.forEach(r=>{ const div = document.createElement('div'); div.className='room-item'; div.innerHTML = `<img alt="${r.id}" src="${r.image}" /><div class=\"room-meta\"><h4>${r.id}</h4><p>${r.desc}</p></div>
      <div style=\"text-align:right\"><div class=\"muted\">₱${r.price}/night</div>
      <div style=\"margin-top:8px\"><button class=\"select-room\" data-id=\"${r.id}\" data-price=\"${r.price}\">Select</button></div></div>`; list.appendChild(div); }); list.querySelectorAll('.select-room').forEach(btn=>{ btn.addEventListener('click',()=> { const id=btn.dataset.id; const price=+btn.dataset.price; selectRoom(id,price); }); }); }
function selectRoom(id,price){ const room = rooms.find(r => r.id === id); state.selected={id,price,image:room?.image||''}; $('#summaryRoom').textContent = id; $('#summaryImage').src = state.selected.image; updateSummary(); document.querySelectorAll('.room-item').forEach(it => it.style.borderColor='#eee'); const btn = document.querySelector(`.select-room[data-id="${id}"]`); if(btn) btn.closest('.room-item').style.borderColor='rgba(139,69,19,0.9)'; updateProceedButtonState(); }
function nightsBetween(ci,co){ if(!ci||!co) return 0; const a=new Date(ci), b=new Date(co); const diff=(b-a)/(1000*60*60*24); return diff>0?diff:0; }
function updateSummary(){ const nights = nightsBetween(state.checkin,state.checkout); $('#nights').textContent = nights; const price = state.selected ? state.selected.price : 0; $('#roomPrice').textContent = `₱${price}/night`; const subtotal = nights * price; const taxes = Math.round(subtotal * 0.12); $('#taxes').textContent = `₱${taxes}`; $('#total').textContent = `₱${(subtotal + taxes).toLocaleString()}`; $('#summaryDates').textContent = state.checkin && state.checkout ? `${state.checkin} → ${state.checkout}` : 'Select dates'; updateProceedButtonState(); }
function canProceedToPayment(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci || !co) return false; if(nightsBetween(ci,co) <= 0) return false; if(!state.selected) return false; const name = $('#fullname').value ? $('#fullname').value.trim() : ''; const email = $('#email').value ? $('#email').value.trim() : ''; if(!name || !email) return false; return true; }
function updateProceedButtonState(){ const btn = $('#proceedBtn'); if(!btn) return; if(canProceedToPayment()){ btn.disabled = false; btn.title = "Proceed to payment"; btn.style.opacity = '1'; btn.style.cursor = 'pointer'; } else { btn.disabled = true; btn.title = "Complete steps 1 & 2 to proceed"; btn.style.opacity = '0.7'; btn.style.cursor = 'not-allowed'; } }
function goTo(n){ state.step = n; $('#step1').classList.toggle('hidden', n!==1); $('#step2').classList.toggle('hidden', n!==2); $('#step3').classList.toggle('hidden', n!==3); $('#stepLabel1').classList.toggle('active', n===1); $('#stepLabel2').classList.toggle('active', n===2); $('#stepLabel3').classList.toggle('active', n===3); window.scrollTo({top:0,behavior:'smooth'}); }
function prevStep(){ if(state.step>1) goTo(state.step-1) }
function nextFromStep1(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci||!co){alert('Please choose check-in and check-out dates.');return} if(nightsBetween(ci,co)<=0){alert('Check-out must be after check-in.');return} if(!state.selected){alert('Please select a room from the available rooms.');return} state.checkin=ci; state.checkout=co; state.guests = $('#guests').value; updateSummary(); goTo(2); }
function validateGuest(){ const name=$('#fullname').value.trim(), email=$('#email').value.trim(), phone=$('#phone').value.trim(); if(!name||!email){alert('Please enter name and email.');return} state.guestInfo={name,email,phone,requests:$('#requests').value.trim()}; goTo(3); }
function proceedToPayment(){ const ci = $('#checkin').value, co = $('#checkout').value; if(!ci || !co){ alert('Please choose check-in and check-out dates before proceeding.'); goTo(1); return; } if(nightsBetween(ci,co) <= 0){ alert('Check-out must be after check-in.'); goTo(1); return; } if(!state.selected){ alert('Please select a room from the available rooms before proceeding.'); goTo(1); return; } const name = $('#fullname').value ? $('#fullname').value.trim() : ''; const email = $('#email').value ? $('#email').value.trim() : ''; if(!name || !email){ alert('Please enter guest name and email before proceeding to payment.'); goTo(2); return; } state.checkin = ci; state.checkout = co; state.guests = $('#guests').value; state.guestInfo = { name, email, phone: ($('#phone').value||'').trim(), requests: ($('#requests').value||'').trim() }; updateSummary(); goTo(3); }
function copyPaymentInfo(){ const num = document.getElementById('ewalletNumber').textContent.trim(); if(!navigator.clipboard){ const ta = document.createElement('textarea'); ta.value = num; document.body.appendChild(ta); ta.select(); try{ document.execCommand('copy'); alert('Number copied to clipboard'); } catch(e){ alert('Copy failed. Number: ' + num); } document.body.removeChild(ta); return; } navigator.clipboard.writeText(num).then(()=>alert('E-wallet number copied to clipboard'), ()=>alert('Could not copy. Number: ' + num)); }
function confirmBooking(){ if(state.pm==='card'){ if(!$('#cardname').value.trim()||!$('#cardnumber').value.trim()){ alert('Enter card details or choose Pay on Arrival / E-Wallet.'); return; } } else if(state.pm === 'ewallet'){ const confirmSent = confirm(`Please confirm you have sent the payment to:\n\nHotelEase\n09978606886\n\nClick OK if you have already sent the payment and want to proceed. Otherwise click Cancel to review payment instructions.`); if(!confirmSent){ return; } } const booking = { room: state.selected?.id||'—', checkin:state.checkin, checkout:state.checkout, nights:nightsBetween(state.checkin,state.checkout), total:$('#total').textContent, guest: state.guestInfo, paymentMethod: state.pm };
  const bookings = JSON.parse(localStorage.getItem('hotelBookings') || '[]'); bookings.push({ roomNumber: Math.floor(Math.random() * 400) + 101, ...booking }); localStorage.setItem('hotelBookings', JSON.stringify(bookings)); console.log('booking',booking); alert(`Booking confirmed!\n\n${booking.room}\n${booking.checkin} → ${booking.checkout}\nTotal: ${booking.total}\nPayment: ${booking.paymentMethod}`); location.href = "{{ route('home') }}"; }
function initFromQuery(){ const qp = new URLSearchParams(location.search); const pre = qp.get('room'); populateRooms(); if(pre){ const match = rooms.find(r=>r.id.toLowerCase()===pre.toLowerCase()); if(match) selectRoom(match.id,match.price); else selectRoom(pre,0); } $('#checkin').addEventListener('change', e => { state.checkin = e.target.value; updateSummary(); }); $('#checkout').addEventListener('change', e => { state.checkout = e.target.value; updateSummary(); }); $('#guests').addEventListener('change', e => { state.guests = e.target.value; updateProceedButtonState(); }); ['#fullname','#email','#phone','#requests'].forEach(sel=>{ const el = document.querySelector(sel); if(el) el.addEventListener('input', updateProceedButtonState); }); updateSummary(); updateProceedButtonState(); }
document.addEventListener('change', e=>{ if(e.target.name==='pm'){ state.pm=e.target.value; document.getElementById('cardFields').style.display = state.pm==='card' ? 'block' : 'none'; document.getElementById('ewalletFields').style.display = state.pm==='ewallet' ? 'block' : 'none'; } updateProceedButtonState(); });
initFromQuery();
</script>
</body>
</html>

