<?php

/**
 * ============================================
 * CONTROLADOR DE PÁGINAS PÚBLICAS
 * ============================================
 */

class PaginaController {

    public function inicio() {
        require ROOT . '/app/views/web/pagina.php';
    }

    public function nosotros() {
        require ROOT . '/app/views/web/nosotros.php';
    }

    public function requisitos() {
        require ROOT . '/app/views/web/requisitos.php';
    }
}