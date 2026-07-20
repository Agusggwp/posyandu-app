@extends('layouts.app')

@section('content')
<style>
    /* Styling for Accordion headers acting as Static Card Headers in Tabs */
    #settingsAccordion .bg-white > form > button[data-accordion-toggle] {
        pointer-events: none !important;
        cursor: default !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 1.25rem 1.5rem !important;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        text-align: left;
    }
    #settingsAccordion .bg-white > form > button[data-accordion-toggle] svg[data-accordion-icon] {
        display: none !important; /* Hide toggle arrow icon */
    }
    #settingsAccordion .bg-white > form > div[id^="panel-"] {
        display: block !important;
        padding-top: 1.5rem !important;
    }
    
    /* Responsive navbar styling for horizontal scroll on mobile */
    @media (max-width: 1023px) {
        nav[aria-label="Settings navigation"] {
            flex-wrap: nowrap;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        nav[aria-label="Settings navigation"] button {
            border-left-width: 0px !important;
            border-bottom-width: 4px !important;
            border-bottom-color: transparent;
            border-radius: 0px !important;
        }
        nav[aria-label="Settings navigation"] button.active-tab {
            border-bottom-color: #4f46e5 !important;
            background-color: #f5f3ff !important;
            color: #4338ca !important;
        }
    }
</style>

<div class="max-w-6xl mx-auto px-3 sm:px-4">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Sistem</h2>
        <p class="text-gray-500 mt-1.5 text-sm sm:text-base">Konfigurasi dan kustomisasi platform Posyandu Digital Anda</p>
    </div>

    <!-- Success Message removed here because layouts.app already handles it globally -->

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation (Left Column) -->
        <nav class="lg:col-span-4 bg-white rounded-3xl border border-indigo-50/80 p-4 shadow-sm flex flex-col gap-1 overflow-x-auto lg:overflow-x-visible whitespace-nowrap lg:whitespace-normal flex-row lg:flex-col" aria-label="Settings navigation">
            <button type="button" data-tab-toggle="tab-general" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-gears text-indigo-500 w-5 text-center text-base"></i>
                <span>Umum & Sistem</span>
            </button>
            <button type="button" data-tab-toggle="tab-main-dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-chart-line text-indigo-500 w-5 text-center text-base"></i>
                <span>Dashboard Kader</span>
            </button>
            <button type="button" data-tab-toggle="tab-admin-dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-user-shield text-indigo-500 w-5 text-center text-base"></i>
                <span>Dashboard Admin</span>
            </button>
            <button type="button" data-tab-toggle="tab-center-info" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-hospital-user text-indigo-500 w-5 text-center text-base"></i>
                <span>Informasi Posyandu</span>
            </button>
            <button type="button" data-tab-toggle="tab-admin-login" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-right-to-bracket text-indigo-500 w-5 text-center text-base"></i>
                <span>Login Petugas</span>
            </button>
            <button type="button" data-tab-toggle="tab-kk-login" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-user-lock text-indigo-500 w-5 text-center text-base"></i>
                <span>Portal Keluarga</span>
            </button>
            <button type="button" data-tab-toggle="tab-kk-news" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-newspaper text-indigo-500 w-5 text-center text-base"></i>
                <span>Berita Keluarga</span>
            </button>
            <button type="button" data-tab-toggle="tab-landing-page" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm text-left transition hover:bg-slate-50 cursor-pointer border-l-4 border-transparent">
                <i class="fa-solid fa-house text-indigo-500 w-5 text-center text-base"></i>
                <span>Jadwal & Landing Page</span>
            </button>
        </nav>

        <!-- Setting Panel Contents (Right Column) -->
        <div class="lg:col-span-8 space-y-4" id="settingsAccordion">
            <div id="tab-general" class="tab-panel hidden">
                @include('admin.settings.partials.general-system')
            </div>
            <div id="tab-main-dashboard" class="tab-panel hidden">
                @include('admin.settings.partials.main-dashboard')
            </div>
            <div id="tab-admin-dashboard" class="tab-panel hidden">
                @include('admin.settings.partials.admin-dashboard')
            </div>
            <div id="tab-center-info" class="tab-panel hidden">
                @include('admin.settings.partials.center-info')
            </div>
            <div id="tab-admin-login" class="tab-panel hidden">
                @include('admin.settings.partials.admin-login')
            </div>
            <div id="tab-kk-login" class="tab-panel hidden">
                @include('admin.settings.partials.kk-login')
            </div>
            <div id="tab-kk-news" class="tab-panel hidden">
                @include('admin.settings.partials.kk-news')
            </div>
            <div id="tab-landing-page" class="tab-panel hidden">
                @include('admin.settings.partials.landing-page')
            </div>
        </div>
    </div>

    <!-- Information Box -->
    <div class="mt-8 p-5 bg-blue-50/50 border border-blue-100 rounded-3xl shadow-sm">
        <div class="flex gap-4">
            <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                <i class="fa-solid fa-circle-info text-base"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-blue-900">Petunjuk Penggunaan</p>
                <p class="text-xs sm:text-sm text-blue-700 mt-1 leading-relaxed">Pengaturan yang disimpan akan segera memengaruhi seluruh sistem dan landing page. Harap isi data dengan lengkap dan teliti sebelum menekan tombol simpan.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('[data-tab-toggle]');
    const panels = document.querySelectorAll('.tab-panel');

    const switchTab = function (tabId) {
        // Hide all panels
        panels.forEach(function (panel) {
            panel.classList.add('hidden');
        });

        // Show active panel
        const activePanel = document.getElementById(tabId);
        if (activePanel) {
            activePanel.classList.remove('hidden');
        }

        // Update tab buttons style
        tabs.forEach(function (tab) {
            const targetId = tab.getAttribute('data-tab-toggle');
            const isActive = targetId === tabId;

            if (isActive) {
                // Active style (modern border-l-4 + bg-indigo-50/60 + text-indigo-700)
                tab.classList.add('bg-indigo-50/60', 'text-indigo-700', 'border-indigo-600', 'active-tab');
                tab.classList.remove('text-slate-600', 'hover:bg-slate-50', 'border-transparent');
                const icon = tab.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-indigo-500');
                    icon.classList.add('text-indigo-700');
                }
            } else {
                // Non-active style
                tab.classList.remove('bg-indigo-50/60', 'text-indigo-700', 'border-indigo-600', 'active-tab');
                tab.classList.add('text-slate-600', 'hover:bg-slate-50', 'border-transparent');
                const icon = tab.querySelector('i');
                if (icon) {
                    icon.classList.add('text-indigo-500');
                    icon.classList.remove('text-indigo-700');
                }
            }
        });

        // Save active tab in session storage
        sessionStorage.setItem('active_settings_tab', tabId);
    };

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const tabId = tab.getAttribute('data-tab-toggle');
            switchTab(tabId);
        });
    });

    // Load active tab from sessionStorage, default to first tab
    const storedTab = sessionStorage.getItem('active_settings_tab') || 'tab-general';
    switchTab(storedTab);

    // Live preview sync logic
    const textKeys = [
        'system_app_name',
        'system_app_tagline',
        'main_dashboard_checks_title',
        'main_dashboard_nutrition_title',
        'main_dashboard_quick_actions_title',
        'main_dashboard_system_info_title',
        'main_dashboard_stat_note',
        'admin_dashboard_title',
        'admin_dashboard_subtitle',
        'center_email',
        'center_posyandu_date',
        'center_address',
        'admin_login_title',
        'admin_login_subtitle',
        'admin_login_description',
        'kk_login_badge',
        'kk_login_hero_title',
        'kk_login_hero_subtitle',
        'kk_login_feature_1_title',
        'kk_login_feature_1_desc',
        'kk_login_feature_2_title',
        'kk_login_feature_2_desc',
        'kk_login_footer_text',
        'kk_login_form_title',
        'kk_login_form_subtitle',
        'kk_news_title',
        'kk_news_summary',
        'kk_news_content',
        'kk_news_published_at',
        'kk_news_link_label',
        'sched_balita_title',
        'sched_balita_day',
        'sched_balita_time',
        'sched_bumil_title',
        'sched_bumil_day',
        'sched_bumil_time',
        'sched_lansia_title',
        'sched_lansia_day',
        'sched_lansia_time',
        'edu_balita_title',
        'edu_bumil_title',
        'edu_lansia_title',
        'edu_umum_title'
    ];

    textKeys.forEach(function (key) {
        const input = document.getElementById(key);
        if (!input) {
            return;
        }

        const targets = document.querySelectorAll('[data-preview-target="' + key + '"]');
        const sync = function () {
            const value = input.value.trim();
            targets.forEach(function (target) {
                if (value === '') {
                    target.textContent = '-';
                    return;
                }

                target.textContent = value;
            });
        };

        input.addEventListener('input', sync);
        sync();
    });

    const statusInput = document.getElementById('kk_news_status');
    const statusTargets = document.querySelectorAll('[data-preview-target="kk_news_status_label"]');
    if (statusInput && statusTargets.length) {
        const syncStatus = function () {
            const active = statusInput.value === 'active';
            statusTargets.forEach(function (target) {
                target.textContent = active ? 'Aktif' : 'Nonaktif';
                target.className = active
                    ? 'rounded-full px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700'
                    : 'rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-600';
            });
        };

        statusInput.addEventListener('change', syncStatus);
        syncStatus();
    }

    const kkRegistrationInput = document.getElementById('kk_registration_status');
    const kkRegistrationTargets = document.querySelectorAll('[data-preview-target="kk_registration_status_label"]');
    if (kkRegistrationInput && kkRegistrationTargets.length) {
        const syncKkRegistration = function () {
            const active = kkRegistrationInput.value === 'active';
            kkRegistrationTargets.forEach(function (target) {
                target.textContent = active ? 'Aktif' : 'Nonaktif';
            });
        };

        kkRegistrationInput.addEventListener('change', syncKkRegistration);
        syncKkRegistration();
    }

    const kkAutoApproveInput = document.getElementById('kk_auto_approve');
    const kkAutoApproveTargets = document.querySelectorAll('[data-preview-target="kk_auto_approve_label"]');
    if (kkAutoApproveInput && kkAutoApproveTargets.length) {
        const syncKkAutoApprove = function () {
            const active = kkAutoApproveInput.value === 'active';
            kkAutoApproveTargets.forEach(function (target) {
                target.textContent = active ? 'Aktif' : 'Nonaktif';
            });
        };

        kkAutoApproveInput.addEventListener('change', syncKkAutoApprove);
        syncKkAutoApprove();
    }

    const statusLabelMaps = [
        { inputId: 'main_dashboard_show_stats_cards', target: 'main_dashboard_show_stats_cards_label' },
        { inputId: 'main_dashboard_show_card_keluarga', target: 'main_dashboard_show_card_keluarga_label' },
        { inputId: 'main_dashboard_show_card_balita', target: 'main_dashboard_show_card_balita_label' },
        { inputId: 'main_dashboard_show_card_ibu_hamil', target: 'main_dashboard_show_card_ibu_hamil_label' },
        { inputId: 'main_dashboard_show_card_nifas', target: 'main_dashboard_show_card_nifas_label' },
        { inputId: 'main_dashboard_show_card_remaja', target: 'main_dashboard_show_card_remaja_label' },
        { inputId: 'main_dashboard_show_card_lansia', target: 'main_dashboard_show_card_lansia_label' },
        { inputId: 'main_dashboard_show_checks_summary', target: 'main_dashboard_show_checks_summary_label' },
        { inputId: 'main_dashboard_show_checks_balita', target: 'main_dashboard_show_checks_balita_label' },
        { inputId: 'main_dashboard_show_checks_ibu_hamil', target: 'main_dashboard_show_checks_ibu_hamil_label' },
        { inputId: 'main_dashboard_show_checks_nifas', target: 'main_dashboard_show_checks_nifas_label' },
        { inputId: 'main_dashboard_show_checks_remaja', target: 'main_dashboard_show_checks_remaja_label' },
        { inputId: 'main_dashboard_show_checks_lansia', target: 'main_dashboard_show_checks_lansia_label' },
        { inputId: 'main_dashboard_show_nutrition', target: 'main_dashboard_show_nutrition_label' },
        { inputId: 'main_dashboard_show_quick_actions', target: 'main_dashboard_show_quick_actions_label' },
        { inputId: 'main_dashboard_show_action_balita', target: 'main_dashboard_show_action_balita_label' },
        { inputId: 'main_dashboard_show_action_ibu_hamil', target: 'main_dashboard_show_action_ibu_hamil_label' },
        { inputId: 'main_dashboard_show_action_nifas', target: 'main_dashboard_show_action_nifas_label' },
        { inputId: 'main_dashboard_show_action_remaja', target: 'main_dashboard_show_action_remaja_label' },
        { inputId: 'main_dashboard_show_action_lansia', target: 'main_dashboard_show_action_lansia_label' },
        { inputId: 'main_dashboard_show_system_info', target: 'main_dashboard_show_system_info_label' },
        { inputId: 'admin_show_stats_cards', target: 'admin_show_stats_cards_label' },
        { inputId: 'admin_show_recent_users', target: 'admin_show_recent_users_label' },
        { inputId: 'admin_show_recent_activities', target: 'admin_show_recent_activities_label' },
        { inputId: 'admin_show_activity_chart', target: 'admin_show_activity_chart_label' },
        { inputId: 'admin_show_role_distribution', target: 'admin_show_role_distribution_label' },
        { inputId: 'admin_show_quick_actions', target: 'admin_show_quick_actions_label' }
    ];

    statusLabelMaps.forEach(function (mapping) {
        const input = document.getElementById(mapping.inputId);
        const targets = document.querySelectorAll('[data-preview-target="' + mapping.target + '"]');

        if (!input || !targets.length) {
            return;
        }

        const sync = function () {
            const active = input.value === 'active';
            targets.forEach(function (target) {
                target.textContent = active ? 'Aktif' : 'Nonaktif';
            });
        };

        input.addEventListener('change', sync);
        sync();
    });

    const previewToggleMaps = [
        'main_dashboard_show_stats_cards',
        'main_dashboard_show_card_keluarga',
        'main_dashboard_show_card_balita',
        'main_dashboard_show_card_ibu_hamil',
        'main_dashboard_show_card_nifas',
        'main_dashboard_show_card_remaja',
        'main_dashboard_show_card_lansia',
        'main_dashboard_show_checks_summary',
        'main_dashboard_show_checks_balita',
        'main_dashboard_show_checks_ibu_hamil',
        'main_dashboard_show_checks_nifas',
        'main_dashboard_show_checks_remaja',
        'main_dashboard_show_checks_lansia',
        'main_dashboard_show_nutrition',
        'main_dashboard_show_quick_actions',
        'main_dashboard_show_action_balita',
        'main_dashboard_show_action_ibu_hamil',
        'main_dashboard_show_action_nifas',
        'main_dashboard_show_action_remaja',
        'main_dashboard_show_action_lansia',
        'main_dashboard_show_system_info'
    ];

    previewToggleMaps.forEach(function (inputId) {
        const input = document.getElementById(inputId);
        const targets = document.querySelectorAll('[data-preview-toggle="' + inputId + '"]');

        if (!input || !targets.length) {
            return;
        }

        const syncToggleVisibility = function () {
            const active = input.value === 'active';
            targets.forEach(function (target) {
                target.classList.toggle('hidden', !active);
            });
        };

        input.addEventListener('change', syncToggleVisibility);
        syncToggleVisibility();
    });

    const newsLinkInput = document.getElementById('kk_news_link_url');
    const newsLinkPreview = document.getElementById('kk_news_link_preview');
    if (newsLinkInput && newsLinkPreview) {
        const syncLinkVisibility = function () {
            if (newsLinkInput.value.trim() === '') {
                newsLinkPreview.classList.add('hidden');
                return;
            }

            newsLinkPreview.classList.remove('hidden');
        };

        newsLinkInput.addEventListener('input', syncLinkVisibility);
        syncLinkVisibility();
    }
});
</script>
@endsection
