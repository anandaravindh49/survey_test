<div>
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ __('Dashboard') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Welcome back! Here\'s your user management overview.') }}</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-900/50 border border-slate-200 dark:border-slate-700 p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="absolute top-0 right-0 w-20 h-20 bg-slate-200 dark:bg-slate-700 rounded-full -mr-10 -mt-10 opacity-40"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="rounded-full bg-slate-400 bg-opacity-10 p-3 group-hover:bg-opacity-20 transition-all">
                        <svg class="w-6 h-6 text-slate-700 dark:text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM16 11a2 2 0 11-4 0 2 2 0 014 0zM18 14a4 4 0 01-4 4v-2a2 2 0 104 0v2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-700 px-3 py-1 rounded-full">{{ __('Total') }}</span>
                </div>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">{{ __('Total Users') }}</p>
                <p class="text-4xl font-bold text-slate-900 dark:text-slate-100">{{ $totalUsers }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">{{ __('Across all statuses') }}</p>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800/50 p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-200 dark:bg-emerald-700/30 rounded-full -mr-10 -mt-10 opacity-40"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="rounded-full bg-emerald-500 bg-opacity-10 p-3 group-hover:bg-opacity-20 transition-all">
                        <svg class="w-6 h-6 text-emerald-700 dark:text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-900/50 px-3 py-1 rounded-full">{{ __('Active') }}</span>
                </div>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">{{ __('Active Users') }}</p>
                <p class="text-4xl font-bold text-emerald-700 dark:text-emerald-400">{{ $activeUsers }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">{{ round(($activeUsers / max($totalUsers, 1)) * 100, 1) }}% of total</p>
            </div>
        </div>

        <!-- Inactive Users Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800/50 p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="absolute top-0 right-0 w-20 h-20 bg-amber-200 dark:bg-amber-700/30 rounded-full -mr-10 -mt-10 opacity-40"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="rounded-full bg-amber-500 bg-opacity-10 p-3 group-hover:bg-opacity-20 transition-all">
                        <svg class="w-6 h-6 text-amber-700 dark:text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/50 px-3 py-1 rounded-full">{{ __('Inactive') }}</span>
                </div>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">{{ __('Inactive Users') }}</p>
                <p class="text-4xl font-bold text-amber-700 dark:text-amber-400">{{ $inactiveUsers }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">{{ round(($inactiveUsers / max($totalUsers, 1)) * 100, 1) }}% of total</p>
            </div>
        </div>

        <!-- Suspended Users Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 border border-rose-200 dark:border-rose-800/50 p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="absolute top-0 right-0 w-20 h-20 bg-rose-200 dark:bg-rose-700/30 rounded-full -mr-10 -mt-10 opacity-40"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="rounded-full bg-rose-500 bg-opacity-10 p-3 group-hover:bg-opacity-20 transition-all">
                        <svg class="w-6 h-6 text-rose-700 dark:text-rose-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-900/50 px-3 py-1 rounded-full">{{ __('Suspended') }}</span>
                </div>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">{{ __('Suspended Users') }}</p>
                <p class="text-4xl font-bold text-rose-700 dark:text-rose-400">{{ $suspendedUsers }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">{{ round(($suspendedUsers / max($totalUsers, 1)) * 100, 1) }}% of total</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Status Pie Chart -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ __('User Status Distribution') }}</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ __('Breakdown of all user statuses') }}</p>
                </div>
                <div class="rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 p-3">
                    <svg class="w-6 h-6 text-indigo-700 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Active vs Inactive Chart -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ __('User Status Comparison') }}</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ __('Detailed breakdown of all user statuses') }}</p>
                </div>
                <div class="rounded-full bg-gradient-to-br from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 p-3">
                    <svg class="w-6 h-6 text-cyan-700 dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let statusChart = null;
        let activityChart = null;
        let chartInitTimeout = null;

        function initializeCharts() {
            // Clear any pending timeouts
            if (chartInitTimeout) {
                clearTimeout(chartInitTimeout);
            }

            chartInitTimeout = setTimeout(function() {
                const statusCtxElement = document.getElementById('statusChart');
                const activityCtxElement = document.getElementById('activityChart');

                if (!statusCtxElement || !activityCtxElement) {
                    console.warn('Canvas elements not found');
                    return;
                }

                // Destroy existing charts before reinitializing
                try {
                    if (statusChart) {
                        statusChart.destroy();
                        statusChart = null;
                    }
                    if (activityChart) {
                        activityChart.destroy();
                        activityChart = null;
                    }
                } catch (e) {
                    console.log('Chart cleanup:', e);
                }

                // Reset canvas elements
                statusCtxElement.width = statusCtxElement.parentElement.offsetWidth;
                statusCtxElement.height = statusCtxElement.parentElement.offsetHeight;
                activityCtxElement.width = activityCtxElement.parentElement.offsetWidth;
                activityCtxElement.height = activityCtxElement.parentElement.offsetHeight;

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#9ca3af' : '#6b7280';
                const borderColor = isDark ? '#374151' : '#e5e7eb';

                // Initialize Status Chart (Pie Chart)
                try {
                    const ctx = statusCtxElement.getContext('2d');
                    if (!ctx) {
                        console.error('Could not get 2D context for status chart');
                        return;
                    }

                    statusChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Active', 'Inactive', 'Suspended'],
                            datasets: [{
                                data: [{{ $activeUsers }}, {{ $inactiveUsers }}, {{ $suspendedUsers }}],
                                backgroundColor: ['#6ee7b7', '#fcd34d', '#fca5a5'],
                                borderColor: isDark ? '#1f2937' : '#ffffff',
                                borderWidth: 3,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: textColor,
                                        padding: 20,
                                        font: { size: 12, weight: '500' },
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: isDark ? '#374151' : '#1f2937',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    padding: 12,
                                    cornerRadius: 8,
                                    titleFont: { weight: 'bold' },
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.parsed || 0;
                                            const total = {{ $totalUsers }} || 1;
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return label + ': ' + value + ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                    console.log('✅ Pie chart initialized');
                } catch (e) {
                    console.error('❌ Error initializing pie chart:', e);
                }

                // Initialize Activity Chart (Bar Chart) with small delay
                setTimeout(function() {
                    try {
                        const ctx = activityCtxElement.getContext('2d');
                        if (!ctx) {
                            console.error('Could not get 2D context for activity chart');
                            return;
                        }

                        activityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Active', 'Inactive', 'Suspended'],
                                datasets: [{
                                    label: 'Number of Users',
                                    data: [{{ $activeUsers }}, {{ $inactiveUsers }}, {{ $suspendedUsers }}],
                                    backgroundColor: ['#6ee7b7', '#fcd34d', '#fca5a5'],
                                    borderColor: ['#34d399', '#fbbf24', '#f87171'],
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    hoverBackgroundColor: ['#34d399', '#fbbf24', '#f87171']
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        labels: {
                                            color: textColor,
                                            font: { size: 12, weight: '500' },
                                            padding: 15
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: isDark ? '#374151' : '#1f2937',
                                        titleColor: '#ffffff',
                                        bodyColor: '#ffffff',
                                        padding: 12,
                                        cornerRadius: 8,
                                        titleFont: { weight: 'bold' }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            color: textColor,
                                            font: { size: 11 }
                                        },
                                        grid: {
                                            color: borderColor,
                                            drawBorder: false
                                        }
                                    },
                                    y: {
                                        ticks: {
                                            color: textColor,
                                            font: { size: 11 }
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                        console.log('✅ Bar chart initialized');
                    } catch (e) {
                        console.error('❌ Error initializing bar chart:', e);
                    }
                }, 100);
            }, 500);
        }

        // Initialize charts when page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCharts);
        } else {
            initializeCharts();
        }

        window.addEventListener('load', initializeCharts);

        // Reinitialize charts when Livewire component is mounted or updated
        document.addEventListener('livewire:initialized', initializeCharts);
        
        // For when component is loaded via navigation
        window.addEventListener('livewire:navigated', function() {
            console.log('📊 Dashboard navigated - initializing charts...');
            setTimeout(initializeCharts, 300);
        });

        // Catch any Livewire updates
        document.addEventListener('livewire:updated', function() {
            console.log('📊 Dashboard updated - initializing charts...');
            initializeCharts();
        });
    </script>
</div>
