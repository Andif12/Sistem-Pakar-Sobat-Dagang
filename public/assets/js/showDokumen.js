function toggleModal(show, fileUrl = null, status = 'menunggu') {
    const modal = document.getElementById('modalDokumen');
    const container = document.getElementById('dokumenContainer');
    const statusEl = document.getElementById('statusPermohonan');

    if (show) {
        let ext = fileUrl.split('.').pop().toLowerCase();

        if (ext === 'pdf') {
            container.innerHTML = `<iframe src="${fileUrl}" class="w-full h-[500px]" frameborder="0"></iframe>`;
        } else {
            container.innerHTML = `<img src="${fileUrl}" class="w-full h-auto object-contain" />`;
        }

        var stats = {
          'menunggu' : 'Permohonan Masih Dalam Proses',
          'disetujui' : 'Permohonan Disetujui',
          'ditolak' : 'Permohonan Ditolak'
        }
        
        statusEl.textContent = stats[status.toLowerCase()] || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        container.innerHTML = '';
        statusEl.textContent = '';
        modal.classList.add('hidden');
    }
  }