from flask import Flask, request, jsonify

app = Flask(__name__)

# Endpoint utama untuk info API
@app.route('/')
def index():
    return """
    <h1>API Rekomendasi Stok Amann</h1>
    </pre>
    """

# Endpoint untuk menghitung rekomendasi penyaluran
@app.route('/rekomendasi', methods=['POST'])
def rekomendasi():
    data = request.get_json()

    stok_awal = data.get('stok_awal', 0)
    stok_akhir = data.get('stok_akhir', stok_awal - data.get('realisasi', 0))
    realisasi = data.get('realisasi', 0)

    pemakaian = stok_awal - stok_akhir
    klasifikasi = ''
    
    # Rekomendasi awal
    rekomendasi = 0

    if pemakaian >= 0.8 * stok_awal:
        klasifikasi = 'Konsumsi Tinggi'
        rekomendasi = stok_awal + int(0.2 * stok_awal)
    elif pemakaian >= 0.5 * stok_awal:
        klasifikasi = 'Konsumsi Sedang'
        rekomendasi = stok_awal
    else:
        klasifikasi = 'Konsumsi Rendah'
        rekomendasi = max(1, pemakaian)  # agar minimal tetap ada output

    return jsonify({
        'rekomendasi': int(rekomendasi),
        'klasifikasi': klasifikasi
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

