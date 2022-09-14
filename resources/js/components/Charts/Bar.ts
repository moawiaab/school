import { defineComponent, h, onMounted, PropType, ref } from "vue";

import { Bar } from "vue-chartjs";

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    Plugin,
} from "chart.js";
import axios from "axios";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

export default defineComponent({
    name: "BarChart",
    components: {
        Bar,
    },
    props: {
        chart: null,
        chartId: {
            type: String,
            default: "bar-chart",
        },
        width: {
            type: Number,
            default: 400,
        },
        height: {
            type: Number,
            default: 400,
        },
        cssClasses: {
            default: "",
            type: String,
        },
        styles: {
            type: Object as PropType<Partial<CSSStyleDeclaration>>,
            default: () => {},
        },
        plugins: {
            type: Array as PropType<Plugin<"bar">[]>,
            default: () => [],
        },
    },
    setup(props) {
        const chartData = props.chart;

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
        };

        return () =>
            h(Bar, {
                chartData,
                chartOptions,
                chartId: props.chartId,
                width: props.width,
                height: props.height,
                cssClasses: props.cssClasses,
                styles: props.styles,
                plugins: props.plugins,
            });
    },
});
