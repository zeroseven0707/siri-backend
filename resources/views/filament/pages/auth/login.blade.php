<x-filament-panels::page.simple>
    <style>
        /* ── Reset panel background ── */
        .fi-simple-main-ctn {
            background: transparent !important;
        }

        body {
            background: #0f0f13 !important;
        }

        /* ── Animated gradient background ── */
        .siri-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: #0f0f13;
            overflow: hidden;
        }

        .siri-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%);
            top: -150px;
            left: -150px;
            animation: pulse-orb 8s ease-in-out infinite;
        }

        .siri-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168,85,247,0.1) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            animation: pulse-orb 10s ease-in-out infinite reverse;
        }

        .siri-orb-mid {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,0.08) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-orb 12s ease-in-out infinite;
        }

        @keyframes pulse-orb {
            0%, 100% { transform: scale(1) translate(0, 0); opacity: 0.8; }
            50% { transform: scale(1.2) translate(20px, -20px); opacity: 1; }
        }

        /* ── Grid dots overlay ── */
        .siri-grid {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* ── Card wrapper ── */
        .siri-card-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            padding: 2rem 1rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* ── Logo area ── */
        .siri-logo {
            margin-bottom: 2rem;
            text-align: center;
            animation: fade-down 0.6s ease both;
        }

        .siri-logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 0 40px rgba(249,115,22,0.4);
        }

        .siri-logo-icon svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .siri-logo h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .siri-logo p {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.45);
            margin: 0.25rem 0 0;
        }

        /* ── Glass card ── */
        .siri-card {
            width: 100%;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 2rem;
            box-shadow:
                0 0 0 1px rgba(249,115,22,0.05),
                0 25px 50px rgba(0,0,0,0.5);
            animation: fade-up 0.6s ease 0.1s both;
        }

        /* ── Override Filament form elements ── */
        .siri-card .fi-fo-field-wrp label,
        .siri-card .fi-fo-field-wrp .fi-fo-field-wrp-label {
            color: rgba(255,255,255,0.7) !important;
            font-size: 0.8125rem !important;
            font-weight: 500 !important;
        }

        .siri-card input[type="email"],
        .siri-card input[type="password"],
        .siri-card input[type="text"] {
            background: rgba(255,255,255,0.06) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            padding: 0.75rem 1rem !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }

        .siri-card input[type="email"]:focus,
        .siri-card input[type="password"]:focus,
        .siri-card input[type="text"]:focus {
            border-color: rgba(249,115,22,0.5) !important;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.15) !important;
            outline: none !important;
        }

        .siri-card input::placeholder {
            color: rgba(255,255,255,0.25) !important;
        }

        /* ── Submit button ── */
        .siri-card .fi-btn-primary,
        .siri-card button[type="submit"] {
            background: linear-gradient(135deg, #f97316, #ea580c) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.9375rem !important;
            color: #ffffff !important;
            width: 100% !important;
            box-shadow: 0 4px 20px rgba(249,115,22,0.35) !important;
            transition: transform 0.15s, box-shadow 0.15s !important;
        }

        .siri-card .fi-btn-primary:hover,
        .siri-card button[type="submit"]:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 28px rgba(249,115,22,0.5) !important;
        }

        /* ── Checkbox ── */
        .siri-card .fi-checkbox-input {
            accent-color: #f97316 !important;
        }

        /* ── Links ── */
        .siri-card a {
            color: #f97316 !important;
        }

        /* ── Validation errors ── */
        .siri-card .fi-fo-field-wrp-error-message {
            color: #fca5a5 !important;
            font-size: 0.75rem !important;
        }

        /* ── Footer ── */
        .siri-footer {
            margin-top: 1.5rem;
            text-align: center;
            color: rgba(255,255,255,0.25);
            font-size: 0.75rem;
            animation: fade-up 0.6s ease 0.2s both;
        }

        /* ── Animations ── */
        @keyframes fade-down {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Hide default Filament heading inside card ── */
        .fi-simple-header { display: none !important; }
    </style>

    {{-- Animated background --}}
    <div class="siri-bg">
        <div class="siri-grid"></div>
        <div class="siri-orb-mid"></div>
    </div>

    {{-- Content --}}
    <div class="siri-card-wrapper">

        {{-- Logo --}}
        <div class="siri-logo">
            <h1>Siri Admin</h1>
            <p>Masuk ke panel manajemen</p>
        </div>

        {{-- Login form card --}}
        <div class="siri-card">
            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <x-filament::button
                    type="submit"
                    form="form"
                    class="w-full mt-2"
                >
                    Masuk
                </x-filament::button>
            </x-filament-panels::form>
        </div>

        <div class="siri-footer">
            &copy; {{ date('Y') }} Siri &mdash; All rights reserved
        </div>

    </div>
</x-filament-panels::page.simple>
