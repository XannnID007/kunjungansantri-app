@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang, {{ auth()->user()->name }}! 🎉</h5>
                            <p class="mb-4">
                                Anda memiliki <span class="fw-bold">{{ $kunjungan_hari_ini }}</span> kunjungan hari ini.
                                Pantau dan kelola kunjungan santri dengan mudah melalui dashboard ini.
                            </p>

                            <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-sm btn-outline-primary">Lihat
                                Kunjungan</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('template/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-user"></i>
                                    </span>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Santri</span>
                            <h3 class="card-title mb-2">{{ $total_santri }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-group"></i>
                                    </span>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Wali</span>
                            <h3 class="card-title mb-2">{{ $total_wali }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kunjungan dan Chart -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Kunjungan Bulanan</h5>
                        <div id="totalRevenueChart" class="px-2" style="height: 300px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ date('Y') }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                        <a class="dropdown-item" href="javascript:void(0);">{{ date('Y') }}</a>
                                        <a class="dropdown-item" href="javascript:void(0);">{{ date('Y') - 1 }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">Peningkatan Kunjungan</div>

                        <div class="d-flex px-3 pt-2 gap-2 justify-content-between">
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-success p-2">
                                        <i class="bx bx-trending-up text-success"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span>Minggu Ini</span>
                                    <h5 class="mb-0">{{ $kunjungan_minggu_ini }}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2">
                                        <i class="bx bx-calendar text-info"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span>Hari Ini</span>
                                    <h5 class="mb-0">{{ $kunjungan_hari_ini }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kunjungan Terbaru -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Kunjungan Terbaru</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="{{ route('admin.kunjungan.index') }}">Lihat Semua</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @forelse($recent_kunjungan as $kunjungan)
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span
                                        class="avatar-initial rounded bg-label-{{ $kunjungan->status == 'completed' ? 'success' : ($kunjungan->status == 'cancelled' ? 'danger' : 'primary') }}">
                                        <i
                                            class="bx {{ $kunjungan->status == 'completed' ? 'bx-check' : ($kunjungan->status == 'cancelled' ? 'bx-x' : 'bx-revision') }}"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $kunjungan->santri->nama }}</h6>
                                        <small class="text-muted">{{ $kunjungan->waliSantri->nama }}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <span
                                            class="status-{{ $kunjungan->status }} fw-bold">{{ ucfirst($kunjungan->status) }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-4">
                                <p class="mb-0">Tidak ada kunjungan terbaru</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('template/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-js')
    <script>
        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            cardColor = config.colors.white;
            headingColor = config.colors.headingColor;
            labelColor = config.colors.borderColor;
            legendColor = config.colors.borderColor;
            borderColor = config.colors.borderColor;

            // Total Revenue Chart
            const chartLabels = {!! json_encode($labels) !!};
            const chartData = {!! json_encode($data) !!};

            const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
                totalRevenueChartOptions = {
                    series: [{
                        name: 'Kunjungan',
                        data: chartData
                    }],
                    chart: {
                        height: 300,
                        type: 'bar',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '50%',
                            borderRadius: 4
                        }
                    },
                    colors: [config.colors.primary],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: true,
                        horizontalAlign: 'left',
                        position: 'top',
                        markers: {
                            height: 8,
                            width: 8,
                            radius: 12,
                            offsetX: -3
                        },
                        labels: {
                            colors: legendColor
                        },
                        itemMargin: {
                            horizontal: 10
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        padding: {
                            top: 0,
                            bottom: -8,
                            left: 20,
                            right: 20
                        }
                    },
                    xaxis: {
                        categories: chartLabels,
                        labels: {
                            style: {
                                fontSize: '13px',
                                colors: labelColor
                            }
                        },
                        axisTicks: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '13px',
                                colors: labelColor
                            }
                        }
                    },
                    responsive: [{
                            breakpoint: 1700,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '35%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 1440,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '42%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 1300,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '48%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 1200,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '40%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 1040,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 11,
                                        columnWidth: '48%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 991,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '30%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 840,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '35%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 768,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '28%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 640,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '32%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '37%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 480,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '45%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '52%'
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 380,
                            options: {
                                plotOptions: {
                                    bar: {
                                        borderRadius: 10,
                                        columnWidth: '60%'
                                    }
                                }
                            }
                        }
                    ],
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };

            if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
                const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
                totalRevenueChart.render();
            }
        })();
    </script>
@endsection
