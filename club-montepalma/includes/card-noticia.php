<?php
/**
 * card-noticia.php
 * Uso: include 'card-noticia.php'; pasando $noticia como array:
 * [
 *   'titulo'            => string,
 *   'contenido'         => string,
 *   'imagen'            => string|null,
 *   'fecha_publicacion' => string,
 *   'autor_nombre'      => string,
 * ]
 */
if (!isset($noticia)) return;
?>
<div class="noticia-card">
    <?php if (!empty($noticia['imagen'])): ?>
    <div class="noticia-card-img">
        <img src="/club-montepalma/public/assets/images/noticias/<?= htmlspecialchars($noticia['imagen']) ?>"
             alt="<?= htmlspecialchars($noticia['titulo']) ?>">
    </div>
    <?php endif; ?>
    <div class="noticia-card-body">
        <span class="noticia-card-fecha">
            <?= date('d M Y', strtotime($noticia['fecha_publicacion'])) ?>
        </span>
        <h3 class="noticia-card-titulo"><?= htmlspecialchars($noticia['titulo']) ?></h3>
        <p class="noticia-card-resumen">
            <?= htmlspecialchars(mb_substr(strip_tags($noticia['contenido']), 0, 120)) ?>…
        </p>
        <span class="noticia-card-autor">Por <?= htmlspecialchars($noticia['autor_nombre'] ?? 'Redacción') ?></span>
    </div>
</div>