<?php

class ModelStatistique {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Nombre total d'utilisateurs
    public function getTotalUtilisateurs() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM users");
        return $stmt->fetch()['total'];
    }

    // Nombre total d'événements
    public function getTotalEvenements() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM events");
        return $stmt->fetch()['total'];
    }

    // Nombre total de billets vendus
    public function getTotalBilletsVendus() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM reservations WHERE status = 'confirmed'");
        return $stmt->fetch()['total'];
    }

    // Revenu total généré par les ventes de billets
    public function getRevenuTotal() {
        $stmt = $this->pdo->query("SELECT SUM(event_price) AS total FROM reservations JOIN events ON reservations.event_id = events.event_id WHERE reservations.status = 'confirmed'");
        return $stmt->fetch()['total'] ?: 0;
    }

    // Nombre d'événements en attente de validation
    public function getEvenementsEnAttente() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM events WHERE event_status = 'pending'");
        return $stmt->fetch()['total'];
    }

    // Nombre d'utilisateurs par rôle
    public function getUtilisateursParRole() {
        $stmt = $this->pdo->query("SELECT role_name, COUNT(*) AS total FROM users JOIN roles ON users.role_id = roles.role_id GROUP BY role_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Statistiques des ventes par événement
    public function getVentesParEvenement() {
        $stmt = $this->pdo->query("SELECT e.event_title, COUNT(r.reservation_id) AS billets_vendus, SUM(e.event_price) AS revenus 
                                   FROM reservations r
                                   JOIN events e ON r.event_id = e.event_id
                                   WHERE r.status = 'confirmed'
                                   GROUP BY e.event_title");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top 5 événements les plus populaires (par billets vendus)
    public function getTopEvenements() {
        $stmt = $this->pdo->query("SELECT e.event_title, COUNT(r.reservation_id) AS billets_vendus 
                                   FROM reservations r
                                   JOIN events e ON r.event_id = e.event_id
                                   WHERE r.status = 'confirmed'
                                   GROUP BY e.event_title
                                   ORDER BY billets_vendus DESC
                                   LIMIT 5");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre de billets vendus par mois
    public function getBilletsVenduesParMois() {
        $stmt = $this->pdo->query("SELECT TO_CHAR(date_reservation, 'YYYY-MM') AS mois, COUNT(*) AS billets_vendus 
                                   FROM reservations
                                   WHERE status = 'confirmed'
                                   GROUP BY mois
                                   ORDER BY mois ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
