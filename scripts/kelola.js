// DOM Elements
const searchInput = document.getElementById('searchInput');
const propertiTable = document.getElementById('propertiTable');
const tableBody = propertiTable.querySelector('tbody');

// Live Search Function
function initializeSearch() {
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            let found = false;
            const cells = row.getElementsByTagName('td');
            
            for (let i = 0; i < cells.length; i++) {
                const cellText = cells[i].textContent.toLowerCase();
                if (cellText.includes(searchTerm)) {
                    found = true;
                    break;
                }
            }
            
            row.style.display = found ? '' : 'none';
        });

        updateNoResultsMessage();
    });
}

// Update pesan "tidak ada hasil" 
function updateNoResultsMessage() {
    const existingMessage = tableBody.querySelector('.no-results-row');
    const visibleRows = Array.from(tableBody.getElementsByTagName('tr'))
        .filter(row => row.style.display !== 'none' && !row.classList.contains('no-results-row'));

    if (visibleRows.length === 0) {
        if (!existingMessage) {
            const messageRow = document.createElement('tr');
            messageRow.className = 'no-results-row';
            messageRow.innerHTML = `
                <td colspan="6" style="text-align: center; padding: 2rem;">
                    <div style="color: #6B7280;">
                        <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        <p>Tidak ada properti yang sesuai dengan pencarian</p>
                    </div>
                </td>
            `;
            tableBody.appendChild(messageRow);
        }
    } else if (existingMessage) {
        existingMessage.remove();
    }
}