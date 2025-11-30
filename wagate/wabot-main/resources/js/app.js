import './bootstrap';
import 'laravel-datatables-vite';

import Alpine from 'alpinejs';

import.meta.glob(['../img/**']);

window.Alpine = Alpine;

Alpine.start();
