function pie(data, names, title, sub_title, seris) {
    return {

        // Colors
        color: [
            '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
            '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
            '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
            '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
        ],

        // Global text styles
        textStyle: {
            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
            fontSize: 13
        },

        // Add title
        title: {
            text: title,
            subtext: sub_title,
            left: 'center',
            textStyle: {
                fontSize: 17,
                fontWeight: 500
            },
            subtextStyle: {
                fontSize: 12
            }
        },

        // Add tooltip
        tooltip: {
            trigger: 'item',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            },
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },

        // Add legend
        legend: {
            orient: 'vertical',
            top: 'center',
            left: 0,
            data: names,
            itemHeight: 8,
            itemWidth: 8
        },

        // Add series
        series: [{
            name: seris,
            type: 'pie',
            radius: '70%',
            center: ['50%', '57.5%'],
            itemStyle: {
                normal: {
                    borderWidth: 1,
                    borderColor: '#fff'
                }
            },
            data: data
        }]
    }
}


function zoom_area(date, sales, purchase) {
    return {

        // Define colors
        color: ['#26A69A','#ec407a','#ffb980','#d87a80'],


        // Global text styles
        textStyle: {
            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
            fontSize: 13
        },

        // Chart animation duration
        animationDuration: 750,

        // Setup grid
        grid: {
            left: 0,
            right: 40,
            top: 35,
            bottom: 60,
            containLabel: true
        },

        // Add legend
        legend: {
            data: ['Sales', 'Purchase'],
            itemHeight: 8,
            itemGap: 20
        },

        // Add tooltip
        tooltip: {
            trigger: 'axis',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            }
        },

        // Horizontal axis
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            axisLabel: {
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            data: date
        }],

        // Vertical axis
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value} ',
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                lineStyle: {
                    color: '#eee'
                }
            },
            splitArea: {
                show: true,
                areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                }
            }
        }],

        // Zoom control
        dataZoom: [
            {
                type: 'inside',
                start: 0,
                end: 30
            },
            {
                show: true,
                type: 'slider',
                start: 30,
                end: 70,
                height: 40,
                bottom: 0,
                borderColor: '#ccc',
                fillerColor: 'rgba(0,0,0,0.05)',
                handleStyle: {
                    color: '#585f63'
                }
            }
        ],

        // Add series
        series: [
            {
                name: 'Sales',
                type: 'line',
                smooth: true,
                symbolSize: 6,
                areaStyle: {
                    normal: {
                        opacity: 0.25
                    }
                },
                itemStyle: {
                    normal: {
                        borderWidth: 2
                    }
                },
                data: sales
            },
            {
                name: 'Purchase',
                type: 'line',
                smooth: true,
                symbolSize: 6,
                areaStyle: {
                    normal: {
                        opacity: 0.25
                    }
                },
                itemStyle: {
                    normal: {
                        borderWidth: 2
                    }
                },
                data: purchase
            }
        ]
    }
}

function column_chart(month, sales, purchase) {
    return {

        // Define colors
        color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

        // Global text styles
        textStyle: {
            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
            fontSize: 13
        },

        // Chart animation duration
        animationDuration: 750,

        // Setup grid
        grid: {
            left: 0,
            right: 40,
            top: 35,
            bottom: 0,
            containLabel: true
        },

        // Add legend
        legend: {
            data: ['Sales', 'Purchase'],
            itemHeight: 8,
            itemGap: 20,
            textStyle: {
                padding: [0, 5]
            }
        },

        // Add tooltip
        tooltip: {
            trigger: 'axis',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            }
        },

        // Horizontal axis
        xAxis: [{
            type: 'category',
            data: month,
            axisLabel: {
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                show: true,
                lineStyle: {
                    color: '#eee',
                    type: 'dashed'
                }
            }
        }],

        // Vertical axis
        yAxis: [{
            type: 'value',
            axisLabel: {
                color: '#333'
            },
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                lineStyle: {
                    color: ['#eee']
                }
            },
            splitArea: {
                show: true,
                areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                }
            }
        }],

        // Add series
        series: [
            {
                name: 'Sales',
                type: 'bar',
                data: sales,
                itemStyle: {
                    normal: {
                        label: {
                            show: true,
                            position: 'top',
                            textStyle: {
                                fontWeight: 500
                            }
                        }
                    }
                },
                markLine: {
                    data: [{type: 'average', name: 'Average Sales'}]
                }
            },
            {
                name: 'Purchase',
                type: 'bar',
                data: purchase,
                itemStyle: {
                    normal: {
                        label: {
                            show: true,
                            position: 'top',
                            textStyle: {
                                fontWeight: 500
                            }
                        }
                    }
                },
                markLine: {
                    data: [{type: 'average', name: 'Average Purchase'}]
                }
            }
        ]
    }
}