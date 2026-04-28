<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Tracking | API-Con</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .map-card {
            border: none;
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* --- PROGRESS CONTAINER --- */
        .progress-container {
            position: relative;
            padding: 180px 60px;
            min-height: 450px;
            display: flex;
            align-items: center;
            transition: all 0.5s ease;
        }

        .track-line {
            position: relative;
            width: 100%;
            height: 12px;
            background: #e2e8f0;
            border-radius: 20px;
        }

        /* Animation Fix: transition all allows both width and height to animate */
        .track-fill {
            position: absolute;
            background: #3b82f6;
            border-radius: 20px;
            transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.4);
            top: 0;
            left: 0;
        }

        .station-node {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            background: #fff;
            border: 5px solid #cbd5e1;
            border-radius: 50%;
            z-index: 10;
            transition: all 0.5s ease;
        }

        /* Pulse Animation for Active Stations */
        .station-node.active {
            border-color: #3b82f6;
            background: #3b82f6;
            animation: pulse-blue 2s infinite;
        }

        @keyframes pulse-blue {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        /* Label Logic: Wrap text instead of ellipsis */
        .label-wrapper {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100px;
        }

        .station-city {
            font-weight: 800;
            font-size: 0.75rem;
            color: #1e293b;
            display: block;
            line-height: 1.1;
            white-space: normal;
            word-wrap: break-word;
            margin-bottom: 4px;
        }

        .station-time {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 700;
        }

        /* Desktop: Up and Down Staggering */
        .station-node:nth-child(odd) .label-wrapper {
            bottom: -90px;
        }

        .station-node:nth-child(even) .label-wrapper {
            top: -90px;
        }

        /* --- MOBILE MODE (< 768px) --- */
        @media (max-width: 767.98px) {
            .progress-container {
                padding: 60px 20px;
                min-height: 800px;
                justify-content: center;
                flex-direction: column;
            }

            .track-line {
                width: 10px;
                height: 700px;
                /* Fixed height for vertical animation */
                left: 0;
            }

            .station-node {
                left: 50% !important;
                transform: translate(-50%, 0);
                top: auto;
            }

            /* Mobile Zig-Zag: Left and Right */
            .label-wrapper {
                transform: none !important;
                top: -15px !important;
                bottom: auto !important;
                width: 120px;
            }

            .station-node:nth-child(odd) .label-wrapper {
                left: auto !important;
                right: 45px !important;
                text-align: right;
            }

            .station-node:nth-child(even) .label-wrapper {
                left: 45px !important;
                text-align: left;
            }
        }

        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body>

    <div id="app" class="container py-4" v-cloak>
        @verbatim
        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3 text-muted">Calculating real-time route progress...</p>
        </div>

        <div v-else>
            <div class="card border-0 rounded-4 shadow-sm mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="h3 fw-800 mb-0">{{ train.name }}</h1>
                        <div class="mt-2">
                            <span class="badge bg-primary px-3 py-2 text-uppercase">{{ train.class }}</span>
                            <span class="ms-2 text-muted small">Updated Live</span>
                        </div>
                    </div>
                    <div class="text-lg-end">
                        <p class="text-muted small mb-0">Local Time</p>
                        <h3 class="fw-bold text-primary mb-0">{{ currentTime.toLocaleTimeString('id-ID') }}</h3>
                    </div>
                </div>
            </div>

            <div class="card map-card">
                <div class="progress-container">
                    <div v-if="processedRoutes.length > 0" class="track-line">
                        <div class="track-fill" :style="fillStyles"></div>

                        <div v-for="stop in processedRoutes"
                            :key="stop.id"
                            class="station-node"
                            :class="{ 'active': isReached(stop.arrivalDate) }"
                            :style="getNodeStyles(stop.position)">

                            <div class="label-wrapper">
                                <span class="station-city">{{ stop.location }}</span>
                                <span class="station-time">{{ stop.arrival_time.substring(0, 5) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endverbatim
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const {
            createApp,
            ref,
            computed,
            onMounted,
            onUnmounted
        } = Vue

        createApp({
            setup() {
                const train = ref({
                    routes: []
                })
                const loading = ref(true)
                const currentTime = ref(new Date())
                const isMobile = ref(window.innerWidth < 768)
                let timer

                const loadData = async () => {
                    try {
                        const id = window.location.pathname.split('/').pop()
                        const response = await axios.get(`/api/train/${id}`)
                        train.value = response.data
                        loading.value = false
                    } catch (e) {
                        console.error("Data Fetch Failed:", e)
                    }
                }

                const parseTime = (timeStr, baseDate = new Date()) => {
                    const [h, m, s] = timeStr.split(':')
                    const d = new Date(baseDate)
                    d.setHours(h, m, s, 0)
                    return d
                }

                // Normalizes times to handle trips crossing midnight
                const processedRoutes = computed(() => {
                    if (!train.value.routes.length) return []
                    const sorted = [...train.value.routes].sort((a, b) => a.order - b.order)

                    const startTime = parseTime(sorted[0].arrival_time)
                    let lastDate = startTime

                    const normalized = sorted.map(r => {
                        let arrivalDate = parseTime(r.arrival_time)
                        if (arrivalDate < lastDate) {
                            arrivalDate.setDate(arrivalDate.getDate() + 1)
                        }
                        lastDate = arrivalDate
                        return {
                            ...r,
                            arrivalDate
                        }
                    })

                    const tripEnd = normalized[normalized.length - 1].arrivalDate
                    const totalDuration = tripEnd - startTime

                    return normalized.map(r => ({
                        ...r,
                        position: totalDuration > 0 ? ((r.arrivalDate - startTime) / totalDuration) * 100 : 0
                    }))
                })

                const progressRate = computed(() => {
                    if (!processedRoutes.value.length) return 0
                    const start = processedRoutes.value[0].arrivalDate
                    const end = processedRoutes.value[processedRoutes.value.length - 1].arrivalDate
                    return Math.max(0, Math.min(1, (currentTime.value - start) / (end - start)))
                })

                // Dynamic styles to support Top-to-Bottom animation on mobile
                const fillStyles = computed(() => {
                    const p = (progressRate.value * 100) + '%'
                    return isMobile.value ?
                        {
                            height: p,
                            width: '100%',
                            top: '0'
                        } :
                        {
                            width: p,
                            height: '100%',
                            left: '0'
                        }
                })

                const getNodeStyles = (pos) => {
                    return isMobile.value ? {
                        top: pos + '%'
                    } : {
                        left: pos + '%'
                    }
                }

                const isReached = (stopDate) => stopDate <= currentTime.value

                onMounted(() => {
                    loadData()
                    timer = setInterval(() => {
                        currentTime.value = new Date()
                    }, 1000)
                    window.addEventListener('resize', () => {
                        isMobile.value = window.innerWidth < 768
                    })
                })

                onUnmounted(() => {
                    clearInterval(timer)
                })

                return {
                    train,
                    loading,
                    currentTime,
                    processedRoutes,
                    progressRate,
                    isReached,
                    fillStyles,
                    getNodeStyles
                }
            }
        }).mount('#app')
    </script>
</body>

</html>