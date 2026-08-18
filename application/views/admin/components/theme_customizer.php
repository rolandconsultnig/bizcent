<!-- ==================== LIVE THEME & UI/UX CUSTOMIZER ==================== -->
<style>
    /* Floating Customizer Button */
    .erp-customizer-trigger {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--erp-accent-gradient);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 8px 24px var(--erp-accent-glow);
        cursor: pointer;
        z-index: 9999;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    .erp-customizer-trigger:hover {
        transform: scale(1.1) rotate(45deg);
    }

    /* Slide-out Customizer Drawer */
    .erp-customizer-panel {
        position: fixed;
        top: 0;
        right: -360px;
        width: 340px;
        height: 100vh;
        background: var(--erp-card-bg);
        border-left: 1px solid var(--erp-border);
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 24px;
        overflow-y: auto;
        color: var(--erp-text-main);
    }
    .erp-customizer-panel.open {
        right: 0;
    }
    .erp-customizer-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9998;
        display: none;
    }

    /* Mode Selection Cards */
    .erp-mode-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 12px;
        margin-bottom: 24px;
    }
    .erp-mode-card {
        border: 2px solid var(--erp-border);
        border-radius: var(--erp-radius-sm);
        padding: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s;
        font-weight: 600;
        font-size: 13px;
    }
    .erp-mode-card:hover {
        border-color: var(--erp-accent);
        transform: translateY(-2px);
    }
    .erp-mode-card.active {
        border-color: var(--erp-accent);
        background: var(--erp-accent-light);
        color: var(--erp-accent);
    }

    /* Color Swatches */
    .erp-swatch-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 12px;
        margin-bottom: 24px;
    }
    .erp-swatch-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        padding: 8px;
        border-radius: var(--erp-radius-sm);
        border: 1px solid transparent;
        transition: all 0.15s;
        font-size: 11px;
        font-weight: 600;
    }
    .erp-swatch-btn:hover {
        background: var(--erp-border);
    }
    .erp-swatch-btn.active {
        border-color: var(--erp-accent);
        background: var(--erp-accent-light);
    }
    .erp-color-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<!-- Trigger Button -->
<div class="erp-customizer-trigger" title="Customize Theme & UI" onclick="toggleThemePanel()">
    <i class="fa fa-paint-brush"></i>
</div>

<!-- Backdrop -->
<div class="erp-customizer-backdrop" onclick="toggleThemePanel()"></div>

<!-- Slide-out Drawer Panel -->
<div class="erp-customizer-panel" id="erp_customizer_drawer">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--erp-border);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-sliders text-primary" style="font-size: 18px;"></i>
            <h4 style="margin: 0; font-weight: 800; font-size: 16px;">Theme Customizer</h4>
        </div>
        <button type="button" class="close" onclick="toggleThemePanel()" style="color: var(--erp-text-main); opacity: 0.8; font-size: 24px;">&times;</button>
    </div>

    <!-- 1. Mode Selector -->
    <div>
        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--erp-text-muted);">Appearance Mode</label>
        <div class="erp-mode-grid">
            <div class="erp-mode-card" data-mode="light" onclick="applyMode('light')">
                <i class="fa fa-sun-o" style="font-size: 18px; margin-bottom: 4px; display: block; color: #f59e0b;"></i>
                Light
            </div>
            <div class="erp-mode-card" data-mode="dark" onclick="applyMode('dark')">
                <i class="fa fa-moon-o" style="font-size: 18px; margin-bottom: 4px; display: block; color: #818cf8;"></i>
                Dark
            </div>
            <div class="erp-mode-card" data-mode="dim" onclick="applyMode('dim')">
                <i class="fa fa-adjust" style="font-size: 18px; margin-bottom: 4px; display: block; color: #38bdf8;"></i>
                Midnight
            </div>
            <div class="erp-mode-card" data-mode="oled" onclick="applyMode('oled')">
                <i class="fa fa-circle" style="font-size: 18px; margin-bottom: 4px; display: block; color: #ffffff;"></i>
                OLED
            </div>
        </div>
    </div>

    <!-- 2. Accent Color Swatches -->
    <div>
        <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--erp-text-muted);">Accent Color Palette</label>
        <div class="erp-swatch-grid">
            <div class="erp-swatch-btn" data-accent="indigo" onclick="applyAccent('indigo')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);"></div>
                Indigo
            </div>
            <div class="erp-swatch-btn" data-accent="emerald" onclick="applyAccent('emerald')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #10b981, #0d9488);"></div>
                Emerald
            </div>
            <div class="erp-swatch-btn" data-accent="violet" onclick="applyAccent('violet')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #8b5cf6, #c026d3);"></div>
                Violet
            </div>
            <div class="erp-swatch-btn" data-accent="crimson" onclick="applyAccent('crimson')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #f43f5e, #fb7185);"></div>
                Crimson
            </div>
            <div class="erp-swatch-btn" data-accent="amber" onclick="applyAccent('amber')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #f59e0b, #ea580c);"></div>
                Amber
            </div>
            <div class="erp-swatch-btn" data-accent="cyan" onclick="applyAccent('cyan')">
                <div class="erp-color-circle" style="background: linear-gradient(135deg, #0284c7, #06b6d4);"></div>
                Cyan
            </div>
        </div>
    </div>

    <!-- 3. Quick Links & Reset -->
    <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--erp-border); text-align: center;">
        <button type="button" class="btn btn-default btn-block btn-sm" onclick="resetThemeDefaults()">
            <i class="fa fa-refresh"></i> Reset to Default
        </button>
    </div>
</div>

<script>
    function toggleThemePanel() {
        var panel = $('#erp_customizer_drawer');
        var backdrop = $('.erp-customizer-backdrop');
        if (panel.hasClass('open')) {
            panel.removeClass('open');
            backdrop.fadeOut(200);
        } else {
            panel.addClass('open');
            backdrop.fadeIn(200);
        }
    }

    function applyMode(mode) {
        document.documentElement.setAttribute('data-theme', mode);
        localStorage.setItem('erp_theme_mode', mode);
        $('.erp-mode-card').removeClass('active');
        $('.erp-mode-card[data-mode="' + mode + '"]').addClass('active');

        // Update header quick-toggle icon
        if (mode === 'light') {
            $('#header_theme_icon').removeClass('fa-sun-o').addClass('fa-moon-o');
        } else {
            $('#header_theme_icon').removeClass('fa-moon-o').addClass('fa-sun-o');
        }
    }

    function applyAccent(accent) {
        document.documentElement.setAttribute('data-accent', accent);
        localStorage.setItem('erp_theme_accent', accent);
        $('.erp-swatch-btn').removeClass('active');
        $('.erp-swatch-btn[data-accent="' + accent + '"]').addClass('active');
    }

    function toggleQuickMode() {
        var current = localStorage.getItem('erp_theme_mode') || 'light';
        var next = (current === 'light') ? 'dark' : 'light';
        applyMode(next);
    }

    function resetThemeDefaults() {
        applyMode('light');
        applyAccent('indigo');
    }

    // Initialize Theme on Page Load
    $(document).ready(function() {
        var savedMode = localStorage.getItem('erp_theme_mode') || 'light';
        var savedAccent = localStorage.getItem('erp_theme_accent') || 'indigo';
        applyMode(savedMode);
        applyAccent(savedAccent);
    });
</script>
