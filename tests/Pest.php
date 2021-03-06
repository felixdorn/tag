<?php

expect()->extend('toLookLike', function (string $comparison) {
    $this->value = preg_replace('/\s+/', '', $this->value);

    return $this->toBe(
        preg_replace('/\s+/', '', $comparison)
    );
});
