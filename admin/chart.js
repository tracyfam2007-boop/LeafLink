function createUserParticipationChart(labels, data) {

    const canvas = document.getElementById('userParticipationChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,

            datasets: [{
                label: 'Submissions',
                data: data,
                borderWidth: 1,
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,
            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },

                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Submissions'
                    }
                }
            }
        }
    });
}

function createGreenActivityChart(labels, data) {

    const canvas = document.getElementById('greenActivityChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [{
                label: 'Submissions',
                data: data,
                borderWidth: 1
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,
            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Green Activity'
                    }
                },

                y: {

                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Submissions'
                    }
                }
            }
        }
    });
}

function createPointDistributionChart(labels, earnedData, redeemedData) {

    const canvas = document.getElementById('pointDistributionChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [
                {
                    label: 'Points Earned',
                    data: earnedData,
                    borderWidth: 1
                },
                {
                    label: 'Points Redeemed',
                    data: redeemedData,
                    borderWidth: 1
                }
            ]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Month'
                    }
                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Points'
                    }
                }
            }
        }
    });
}

function createPointsByActivityChart(labels, data) {

    const canvas = document.getElementById('pointsByActivityChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [

                {
                    label: 'Points Earned',
                    data: data,
                    borderWidth: 1
                }

            ]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: true

                }

            },

            scales: {

                x: {

                    title: {

                        display: true,
                        text: 'Green Activity'

                    }

                },

                y: {

                    beginAtZero: true,

                    title: {

                        display: true,
                        text: 'Points'

                    }
                }
            }
        }
    });
}

function createRewardRedemptionChart(labels, data) {

    const canvas = document.getElementById('rewardRedemptionChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [{
                label: 'Redemptions',
                data: data,
                borderWidth: 1
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,
            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Month'
                    }
                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Redemptions'
                    }
                }
            }
        }
    });
}

function createMostRedeemedRewardChart(labels, data) {

    const canvas = document.getElementById('mostRedeemedRewardChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [
                {
                    label: 'Redemptions',
                    data: data,
                    borderWidth: 1
                }
            ]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,
            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Reward'
                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Redemptions'
                    }
                }
            }
        }
    });
}

function createGreenActivityMonthChart(labels, data) {

    const canvas = document.getElementById('greenActivityMonthChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Submissions',
                data: data,
                borderWidth: 1
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Month'
                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Submissions'
                    }
                }
            }
        }
    });
}

function createGreenActivityParticipationChart(labels, data) {

    const canvas = document.getElementById('greenActivityParticipationChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,
            datasets: [

                {
                    label: 'Submissions',
                    data: data,
                    borderWidth: 1
                }

            ]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: true

                }

            },

            scales: {

                x: {

                    title: {

                        display: true,
                        text: 'Green Activity'

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    },

                    title: {

                        display: true,
                        text: 'Number of Submissions'

                    }
                }
            }
        }
    });
}

function createTeamChallengeChart(labels, data) {

    const canvas = document.getElementById('teamChallengeChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,

            datasets: [{
                label: 'Team Challenges',
                data: data,
                borderWidth: 1
            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Month'
                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Team Challenges'
                    }
                }
            }
        }
    });
}

function createTeamChallengeParticipationChart(labels, data) {

    const canvas = document.getElementById('teamChallengeParticipationChart');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',
        data: {

            labels: labels,

            datasets: [{
                label: 'Team Members',
                data: data,
                borderWidth: 1
            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                x: {

                    title: {
                        display: true,
                        text: 'Team Challenge'
                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {
                        display: true,
                        text: 'Number of Team Members'
                    }
                }
            }
        }
    });
}