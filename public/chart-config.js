// chart-toolkit.js

// Couleurs par défaut harmonisées avec un design Bento
const chartColors = {
    purple: {
        fill: "rgba(139, 92, 246, 0.2)",
        stroke: "rgba(139, 92, 246, 1)",
        point: "rgba(139, 92, 246, 1)",
        pointHover: "rgba(124, 58, 237, 1)",
    },
    blue: {
        fill: "rgba(59, 130, 246, 0.2)",
        stroke: "rgba(59, 130, 246, 1)",
        point: "rgba(59, 130, 246, 1)",
        pointHover: "rgba(37, 99, 235, 1)",
    },
    emerald: {
        fill: "rgba(16, 185, 129, 0.2)",
        stroke: "rgba(16, 185, 129, 1)",
        point: "rgba(16, 185, 129, 1)",
        pointHover: "rgba(5, 150, 105, 1)",
    },
    amber: {
        fill: "rgba(245, 158, 11, 0.2)",
        stroke: "rgba(245, 158, 11, 1)",
        point: "rgba(245, 158, 11, 1)",
        pointHover: "rgba(217, 119, 6, 1)",
    },
    rose: {
        fill: "rgba(244, 63, 94, 0.2)",
        stroke: "rgba(244, 63, 94, 1)",
        point: "rgba(244, 63, 94, 1)",
        pointHover: "rgba(225, 29, 72, 1)",
    },
}

// Configuration globale (s’applique une fois pour tous les graphiques)
Chart.defaults.font.family = "'Inter', sans-serif"
Chart.defaults.font.size = 12
Chart.defaults.color = "rgba(75, 85, 99, 1)"
Chart.defaults.elements.line.tension = 0.4
Chart.defaults.elements.line.borderWidth = 2
Chart.defaults.elements.point.radius = 4
Chart.defaults.elements.point.hoverRadius = 6
Chart.defaults.plugins.tooltip = {
    backgroundColor: "rgba(255, 255, 255, 0.9)",
    titleColor: "rgba(17, 24, 39, 1)",
    bodyColor: "rgba(75, 85, 99, 1)",
    borderColor: "rgba(229, 231, 235, 1)",
    borderWidth: 1,
    padding: 10,
    cornerRadius: 6,
    displayColors: true,
    boxPadding: 3,
    usePointStyle: true,
}
Chart.defaults.plugins.legend.display = false

// 🛠️ Fonction utilitaire principale
export function createChart(ctx, chartData, options = {}, config = {}) {
    const defaultChartType = config.type || "line"
    const useGradient = config.gradient || false
    const defaultColorKeys = Object.keys(chartColors)

    const finalDatasets = chartData.datasets.map((ds, index) => {
        const colorKey = ds.colorSet || defaultColorKeys[index % defaultColorKeys.length]
        const colors = chartColors[colorKey]

        const gradient = useGradient
            ? (() => {
                const g = ctx.createLinearGradient(0, 0, 0, 400)
                g.addColorStop(0, colors.fill)
                g.addColorStop(1, "rgba(255, 255, 255, 0)")
                return g
            })()
            : colors.fill

        return {
            ...ds,
            backgroundColor: ds.backgroundColor || gradient,
            borderColor: ds.borderColor || colors.stroke,
            pointBackgroundColor: ds.pointBackgroundColor || colors.point,
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: ds.pointHoverBackgroundColor || colors.pointHover,
            pointHoverBorderColor: "#fff",
            fill: ds.fill !== undefined ? ds.fill : true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: defaultChartType === "line" && config.area ? 0 : 4,
            pointHoverRadius: 6,
        }
    })

    return new Chart(ctx, {
        type: defaultChartType,
        data: {
            labels: chartData.labels,
            datasets: finalDatasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: "nearest",
                axis: "x",
                intersect: false,
            },
            scales: {
                x: {
                    grid: {
                        color: "rgba(243, 244, 246, 1)",
                        borderDash: [4, 4],
                        display: config.hideXGrid ? false : true,
                    },
                    ticks: { padding: 10 },
                },
                y: {
                    grid: {
                        color: "rgba(243, 244, 246, 0.7)",
                        borderDash: [4, 4],
                    },
                    ticks: { padding: 10 },
                    beginAtZero: true,
                },
            },
            plugins: {
                tooltip: {
                    mode: "index",
                    intersect: false,
                    callbacks: {
                        label: (context) => {
                            const label = context.dataset.label || ""
                            const value = context.parsed.y
                            return label
                                ? `${label}: ${new Intl.NumberFormat("fr-FR", {
                                    style: "currency",
                                    currency: "EUR",
                                }).format(value)}`
                                : new Intl.NumberFormat("fr-FR", {
                                    style: "currency",
                                    currency: "EUR",
                                }).format(value)
                        },
                    },
                },
                ...options.plugins,
            },
            ...options,
        },
    })
}
