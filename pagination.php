<?php
// pagination.php
if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "&records=$recordsPerPage&search=" . urlencode($searchTerm) . "&role=" . urlencode($filterRole) . "'>&laquo; Previous</a>";
}
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='?page=$i&records=$recordsPerPage&search=" . urlencode($searchTerm) . "&role=" . urlencode($filterRole) . "'" . ($page == $i ? ' class="active"' : '') . ">$i</a>";
}
if ($page < $totalPages) {
    echo "<a href='?page=" . ($page + 1) . "&records=$recordsPerPage&search=" . urlencode($searchTerm) . "&role=" . urlencode($filterRole) . "'>Next &raquo;</a>";
}
?>
