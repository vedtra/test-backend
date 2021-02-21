<?php

function rupiah($angka)
{
	$hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
	return $hasil_rupiah;
}

function cacheName($url, $params)
{

	$queryString = http_build_query($params);

	$fullUrl = "{$url}?{$queryString}";
	return $fullUrl;
}
