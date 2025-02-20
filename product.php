echo "<p>Stok: " . $product['stock'] . "</p>";

if ($product['stock'] > 0) {
    echo '<button class="btn-add-to-cart">Tambah ke Keranjang</button>';
} else {
    echo '<button class="btn-disabled" disabled>Habis</button>';
}
