document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#riwayatPermohonan tbody tr');

    function filterTable() {
        const statusValue = statusFilter.value.toLowerCase();
        const dateValue = dateFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        tableRows.forEach(function (row) {
            const cells = row.querySelectorAll('td');
            if (cells.length < 4) return;

            const dateCell = cells[2].innerText.toLowerCase();
            const statusCell = cells[3].innerText.toLowerCase();
            const searchText = row.innerText.toLowerCase();

            const matchesStatus = !statusValue || statusCell.includes(statusValue);
            const matchesDate = !dateValue || dateCell.includes(dateValue);
            const matchesSearch = !searchValue || searchText.includes(searchValue);

            row.style.display = (matchesStatus && matchesDate && matchesSearch) ? '' : 'none';
        });
    }

    statusFilter.addEventListener('change', filterTable);
    dateFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);
});
