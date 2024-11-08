(function ($) {
    'use strict';
    // let line_data = json.loads(custom_admin_vars.line_graph_data)
    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
})(jQuery);
var current_page = window.location.href
console.log(current_page,custom_admin_vars.line_graph_data[7]);
if (current_page === custom_admin_vars.line_graph_data[7]) {
    let total_count_of_signals = custom_admin_vars.line_graph_data[6];
    var seriesData = [
        custom_admin_vars.line_graph_data[0].count,
        custom_admin_vars.line_graph_data[1].count,
        custom_admin_vars.line_graph_data[2].count,
        custom_admin_vars.line_graph_data[3].count,
        custom_admin_vars.line_graph_data[4].count,
        custom_admin_vars.line_graph_data[5].count,
    ];

    function calculatePercentage(seriesData) {
        var percentageArray = seriesData.map(function (value) {
            return (value / total_count_of_signals) * 100;
        });
        return percentageArray;
    }

    var percentageValues = calculatePercentage(seriesData);
    var options = {
        colors: [
            '#02C173',
            '#7EDC6C',
            '#54B941',
            '#54B941',
            '#37EB98',
            '#6EFFC7'],
        series: percentageValues,
        total_count: total_count_of_signals,
        top_counts: seriesData,
        chart: {
            height: 400,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                track: {
                    background: '#09140C',
                    // strokeWidth: '97%',

                    margin: 5,
                    dropShadow: {
                        enabled: false,
                        top: 0,
                        left: 0,
                        blur: 3,
                        opacity: 0.5
                    }
                },
                dataLabels: {
                    name: {
                        fontSize: '20px',
                    },
                    value: {
                        color: '#ffffff',
                        fontSize: '16px',
                        formatter: function (val, opts, index) {
                            value_orginal = val / 100 * opts.config.total_count
                            roundOfValue = Math.round(value_orginal)
                            // console.log(roundOfValue,'==========');
                            return  roundOfValue;
                        },
                    },
                    total: {
                        show: true,
                        label: 'Total',
                        formatter: function (w) {
                            // console.log(w)
                            return w.config.total_count;
                        }
                    }
                }
            }
        },
        stroke: {
            lineCap: "round",
        },
        labels: [
            custom_admin_vars.line_graph_data[0].title,
            custom_admin_vars.line_graph_data[1].title,
            custom_admin_vars.line_graph_data[2].title,
            custom_admin_vars.line_graph_data[3].title,
            custom_admin_vars.line_graph_data[4].title,
            custom_admin_vars.line_graph_data[5].title
        ],


    };

    // console.log(current_page,'====',custom_admin_vars.line_graph_data[7]);
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    let graphData2 = custom_admin_vars.graph2
    let graph_months = custom_admin_vars.graph_months
// console.log(graphData2)
    var options = {
        colors: ["#02C173", "#F8C300"],
        chart: {
            type: 'line',
            color: "#ffffff"
        },
        stroke: {
            curve: 'straight'
        },
        series: [
            {
                name: 'Line 1',
                data: graphData2
            },

        ],
        xaxis: {
            categories: graph_months,
            title: {

                style: {
                    color: '#ffffff',
                    fontSize: '12px',
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-title',
                },
            },
        }
    }

    if (current_page === custom_admin_vars.line_graph_data[7]) {
        var chart = new ApexCharts(document.querySelector("#line-chart"), options);
        chart.render();
    }

}

    function sortByCount(a, b) {
        return b.count - a.count;
    }

    custom_admin_vars.radial_graph.sort(sortByCount);
    function toSentenceCase(str) {
        return str.toLowerCase().replace(/(?:^|\s)\w/g, function(match) {
            return match.toUpperCase();
        });
    }

    custom_admin_vars.radial_graph.forEach(item => {
        item.title = toSentenceCase(item.title);
        if(item.title == 'fx' || item.title == 'Fx'){
            item.title = item.title.toUpperCase();
        }
    });

var totalsignals1 = custom_admin_vars.line_graph_data[6];
    var seriesData = [];

    // Loop through the radial_graph array and extract the count values
    for (let i = 0; i < custom_admin_vars.radial_graph.length; i++) {
        seriesData.push(custom_admin_vars.radial_graph[i].count);
    }

function calculatePercentage(seriesData) {
    var percentageArray = seriesData.map(function (value) {
        return (value / totalsignals1) * 100;
    });
    return percentageArray;
}

var percentageValues = calculatePercentage(seriesData);
var options = {
    colors: [
        '#02C173',
        '#7EDC6C',
        '#54B941',
        '#54B941',
        '#37EB98',
        '#6EFFC7'],
    series: percentageValues,
    total_count: totalsignals1,
    top_counts: seriesData,
    chart: {
        height: 400,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            track: {
                background: '#09140C',
                // strokeWidth: '97%',

                margin: 5,
                dropShadow: {
                    enabled: false,
                    top: 0,
                    left: 0,
                    blur: 3,
                    opacity: 0.5
                }
            },
            dataLabels: {
                name: {
                    fontSize: '20px',
                },
                value: {
                    color: '#ffffff',
                    fontSize: '16px',
                    formatter: function (val, opts, index) {
                        value_orginal = val / 100 * opts.config.total_count
                        roundOfValue = Math.round(value_orginal)
                        // console.log(roundOfValue,'==========');
                        return  roundOfValue;
                    },
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        // console.log(w)
                        return w.config.total_count;
                    }
                }
            }
        }
    },
    stroke: {
        lineCap: "round",
    },
    labels: custom_admin_vars.radial_graph.map(item => item.title)

};

// console.log(current_page,'====',custom_admin_vars.line_graph_data[7]);
var chart = new ApexCharts(document.querySelector("#chart_radial"), options);
chart.render();


