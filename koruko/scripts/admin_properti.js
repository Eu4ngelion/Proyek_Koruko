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
            
            for (let i = 0; i < cells.length - 1; i++) {
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
                <td colspan="7" style="text-align: center; padding: 2rem;">
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

// Delete Property
function deleteProperty(id) {
    if (confirm('Apakah Anda yakin ingin menghapus properti ini?')) {
        const button = event.target;
        const originalText = button.textContent;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch('delete_properti.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = button.closest('tr');
                row.style.transition = 'opacity 0.3s, transform 0.3s';
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                
                setTimeout(() => {
                    row.remove();
                    showNotification('Properti berhasil dihapus', 'success');
                    updateStatistics();
                }, 300);
            } else {
                throw new Error(data.message || 'Gagal menghapus properti');
            }
        })
        .catch(error => {
            showNotification(error.message, 'error');
            button.disabled = false;
            button.textContent = originalText;
        });
    }
}

// Verikasi properti
function verifyProperty(id) {
    const button = event.target;
    const originalText = button.textContent;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('verify_properti.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = button.closest('tr');
            const statusCell = row.querySelector('td:nth-last-child(2)');
            
            const hargaJualCell = row.querySelector('td:nth-child(5)');
            const hasJual = hargaJualCell.textContent.includes('Rp');
            const hasSewa = hargaJualCell.textContent.includes('juta/tahun');
            
            let statusText = '';
            if (hasJual && hasSewa) {
                statusText = '<span class="status active">Dijual + Disewa</span>';
            } else if (hasSewa) {
                statusText = '<span class="status active">Disewa</span>';
            } else {
                statusText = '<span class="status active">Dijual</span>';
            }
            
            statusCell.innerHTML = statusText;
            button.remove();
            
            showNotification('Properti berhasil diverifikasi', 'success');
            updateStatistics();
        } else {
            throw new Error(data.message || 'Gagal memverifikasi properti');
        }
    })
    .catch(error => {
        showNotification(error.message, 'error');
        button.disabled = false;
        button.textContent = originalText;
    });
}

// Update Statistik
function updateStatistics() {
    fetch('get_statistics.php')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.stats-container .stat-value:nth-child(1)').textContent = data.jumlah_ruko;
            document.querySelector('.stats-container .stat-value:nth-child(2)').textContent = data.disewakan;
            document.querySelector('.stats-container .stat-value:nth-child(3)').textContent = data.dijual;
            document.querySelector('.stats-container .stat-value:nth-child(4)').textContent = data.belum_verifikasi;
            document.querySelector('.stats-container .stat-value:nth-child(5)').textContent = data.terjual;
        })
        .catch(error => console.error('Failed to update statistics:', error));
}

// notifikasi
function showNotification(message, type = 'success') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    // Trigger animasi
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 10);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(20px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
});