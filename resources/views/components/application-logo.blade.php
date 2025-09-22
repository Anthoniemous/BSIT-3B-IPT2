<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 120" width="300" height="120">
  <defs>
    <linearGradient id="cartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#4F46E5;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#7C3AED;stop-opacity:1" />
    </linearGradient>
    <linearGradient id="textGradient" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" style="stop-color:#1F2937;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#4B5563;stop-opacity:1" />
    </linearGradient>
  </defs>
  
  <!-- Shopping Cart Icon -->
  <g transform="translate(20, 25)">
    <!-- Cart body -->
    <path d="M10 20 L50 20 L52 35 L8 35 Z" fill="url(#cartGradient)" stroke="none"/>
    
    <!-- Cart handle -->
    <path d="M8 20 L8 15 Q8 12 11 12 L15 12" fill="none" stroke="url(#cartGradient)" stroke-width="3" stroke-linecap="round"/>
    
    <!-- Cart items (packages) -->
    <rect x="15" y="15" width="8" height="6" fill="#F59E0B" rx="1"/>
    <rect x="25" y="12" width="6" height="8" fill="#EF4444" rx="1"/>
    <rect x="33" y="14" width="7" height="6" fill="#10B981" rx="1"/>
    
    <!-- Cart wheels -->
    <circle cx="18" cy="45" r="4" fill="url(#cartGradient)"/>
    <circle cx="42" cy="45" r="4" fill="url(#cartGradient)"/>
    
    <!-- Wheel highlights -->
    <circle cx="18" cy="45" r="2" fill="#FFFFFF" opacity="0.6"/>
    <circle cx="42" cy="45" r="2" fill="#FFFFFF" opacity="0.6"/>
  </g>
  
  <!-- Decorative elements -->
  <circle cx="350" cy="30" r="3" fill="#F59E0B" opacity="0.7"/>
  <circle cx="360" cy="40" r="2" fill="#EF4444" opacity="0.7"/>
  <circle cx="365" cy="50" r="2.5" fill="#10B981" opacity="0.7"/>
  

</svg>