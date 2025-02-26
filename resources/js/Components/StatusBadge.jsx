export default function StatusBadge({ status }) {
    const statusStyles = {
        warning: "bg-yellow-100 text-yellow-800 border-yellow-400",
        danger: "bg-red-100 text-red-800 border-red-400",
        inactive: "bg-gray-100 text-gray-800 border-gray-400",
        active: "bg-green-100 text-green-800 border-green-400",
        resolved: "bg-blue-100 text-blue-800 border-blue-400"
    };

    return (
        <span className={`px-3 py-1 text-sm font-medium rounded-full border ${statusStyles[status]}`}>
            {status.charAt(0).toUpperCase() + status.slice(1)}
        </span>
    );
}