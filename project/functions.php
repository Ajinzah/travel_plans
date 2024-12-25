<?php
function calculate_total_cost($pdo, $trip_id) {
    $query = $pdo->prepare("SELECT SUM(cost) AS total_cost FROM destinasi WHERE trip_id = ?");
    $query->execute([$trip_id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total_cost'] ?? 0;
}
?>

