@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <!-- Header -->
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-gray-600 mt-1">Konfigurasi dan pengaturan aplikasi Posyandu</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Settings Forms -->
    <div class="space-y-3" id="settingsAccordion">
        @include('admin.settings.partials.general-system')
        @include('admin.settings.partials.main-dashboard')
        @include('admin.settings.partials.admin-dashboard')
        @include('admin.settings.partials.center-info')
        @include('admin.settings.partials.admin-login')
        @include('admin.settings.partials.kk-login')
        @include('admin.settings.partials.kk-news')
    </div>

    <!-- Information Box -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">Catatan</p>
                <p class="text-sm text-blue-700 mt-1">Pengaturan ini akan diterapkan di seluruh aplikasi. Pastikan semua data sudah benar sebelum menyimpan.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('[data-accordion-toggle]');
    const toggleAccordion = function (panelId) {
        accordionButtons.forEach(function (button) {
            const targetId = button.getAttribute('data-accordion-toggle');
            const panel = document.getElementById(targetId);
            const icon = document.querySelector('[data-accordion-icon="' + targetId + '"]');
            const isActive = targetId === panelId;

            if (!panel) {
                return;
            }

            if (isActive) {
                const open = panel.classList.contains('hidden');
                if (open) {
                    panel.classList.remove('hidden');
                    button.classList.add('bg-indigo-100');
                    if (icon) {
                        icon.classList.add('rotate-180');
                    }
                } else {
                    panel.classList.add('hidden');
                    button.classList.remove('bg-indigo-100');
                    if (icon) {
                        icon.classList.remove('rotate-180');
                    }
                }

                return;
            }

            panel.classList.add('hidden');
            button.classList.remove('bg-indigo-100');
            if (icon) {
                icon.classList.remove('rotate-180');
            }
        });
    };

    accordionButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const panelId = button.getAttribute('data-accordion-toggle');
            toggleAccordion(panelId);
        });
    });

    if (accordionButtons.length) {
        const firstPanelId = accordionButtons[0].getAttribute('data-accordion-toggle');
        toggleAccordion(firstPanelId);
    }

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
        'center_hours_open',
        'center_hours_close',
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
        'kk_news_link_label'
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
