import { useState } from 'react';
import dayjs from 'dayjs';
import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler } from 'chart.js';

// Registering chart components with Chart.js
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

const LineChart = ({
    label,
    data
}) => {
  const [filter, setFilter] = useState("");

  const filterData = (data) => {
    const now = dayjs();
    return data.filter(({ timestamp }) => {
        const date = dayjs(timestamp);
        if (filter === "lastHour") return date.isAfter(now.subtract(1, "hour"));
        if (filter === "lastDay") return date.isAfter(now.subtract(1, "day"));
        if (filter === "last30Days") return date.isAfter(now.subtract(30, "day"));
        if (filter === "lastMonth") return date.isAfter(now.startOf("month"));
        return true;
    });
  };

  const filteredData = filterData(data);

  // Chart.js data configuration
  const chartData = {
    labels: filteredData.map((row) => row.timestamp), // X-axis labels (years)
    datasets: [
      {
        label: label,
        data: filteredData.map((row) => row.y_data), // Y-axis data (acquisition counts)
        borderColor: 'rgba(128, 192, 192, 1)', // Line color
        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color under the line
        fill: true, // Fill the area under the line
        tension: 0.4, // Curve of the line
        pointRadius: 2, // Size of the points
        pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Point color
        pointBorderColor: 'rgba(255, 255, 255, 1)', // Point border color
      },
    ],
  };

  // Chart.js options configuration
  const options = {
    responsive: true,
    plugins: {
      legend: {
        position: 'top', // Position of the legend
      },
      tooltip: {
        callbacks: {
          label: function (tooltipItem) {
            return `Acquisitions: ${tooltipItem.raw}`; // Custom tooltip
          },
        },
      },
    },
    scales: {
      y: {
        beginAtZero: true, // Ensure Y axis starts from 0
      },
    },
  };

  return (
    <div className='w-[800px] md:w-full'>
      <h2>{label}</h2>

      <div className="flex space-x-4 mb-4">
        {["lastHour", "lastDay", "last30Days", "lastMonth"].map((range) => (
            <button
                key={range}
                onClick={() => setFilter(range)}
                className={`px-4 py-2 border rounded ${
                    filter === range ? "bg-blue-500 text-white" : "bg-gray-200"
                }`}
            >
                {range === "lastDay" ? "Last 24h" : range === "last30Days" ? "Last 30 Days" : range === "lastHour" ? "Last Hour" : "Last Month"}
            </button>
        ))}
    </div>

      <Line data={chartData} options={options} />
    </div>
  );
};

export default LineChart;
