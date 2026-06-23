<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cartas;
use App\Models\Momentos;
use App\Models\valores_compartidos;
use App\Models\respuestas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear usuario por defecto
        User::factory()->create([
            'name' => 'Feñi',
            'email' => 'feni@example.com',
        ]);

        // Crear administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        // 2. Crear cartas emotivas y sinceras
        $carta1 = Cartas::create([
            'titulo' => 'El valor de reconocer mis errores',
            'contenido' => "Feñi,\n\nEscribo esto con el corazón en la mano. He estado pensando mucho en nosotros y en la forma en que las cosas terminaron. Sé que cometí errores, momentos en los que no te escuché como merecías o en los que dejé que el orgullo y las tensiones del día a día ganaran. Me duele ver que descuidé lo más valioso que tenía.\n\nQuiero que sepas que reconozco mis fallas. Esta distancia me ha enseñado a mirar con humildad mis reacciones y el impacto que tuvieron en ti. No busco justificarme, sino pedirte perdón con total honestidad. Mi intención con este espacio es recordarte lo mucho que valoro lo que construimos y mostrarte mi compromiso real para mejorar como persona.\n\nCon cariño y sinceridad,\nYo",
            'fecha' => now()->subDays(5)->format('Y-m-d'),
            'leida' => true,
        ]);

        $carta2 = Cartas::create([
            'titulo' => 'Nuestra promesa de comunicación',
            'contenido' => "Feñi,\n\nUna de las lecciones más grandes que he aprendido es que el amor no solo se siente, sino que se comunica y se cuida. A veces me encerré en mis propios problemas y no supe crear un canal seguro para que expresaras tus dudas o temores. Lamento haber estado a la defensiva en momentos donde solo necesitabas un abrazo y comprensión.\n\nQuiero comprometerme a escucharte activamente, a validar lo que sientes sin juzgar y a hablar siempre desde el respeto y el cariño. Sé que recuperar la confianza toma tiempo, y estoy dispuesto a ir a tu ritmo, paso a paso.\n\nSiempre tuyo,\nYo",
            'fecha' => now()->subDays(3)->format('Y-m-d'),
            'leida' => false,
        ]);

        $carta3 = Cartas::create([
            'titulo' => 'Mirando hacia el futuro con paciencia',
            'contenido' => "Feñi,\n\nSé que no podemos borrar el pasado, pero sí podemos aprender de él para construir algo mejor. No espero que las cosas cambien de la noche a la mañana, pero sí quiero que veas que mis ganas de estar bien y de hacerte feliz son reales.\n\nQuiero que este lugar sea nuestro refugio. Un recordatorio de que, a pesar de los tropiezos, lo que compartimos es único y vale la pena protegerlo. Gracias por leer esto y por darme el espacio para expresar lo que llevo dentro.\n\nUn abrazo fuerte,\nYo",
            'fecha' => now()->subDays(1)->format('Y-m-d'),
            'leida' => false,
        ]);

        // 3. Crear respuestas (comentarios de ejemplo) para la primera carta
        respuestas::create([
            'carta_id' => $carta1->id,
            'nombre' => 'Feñi',
            'comentario' => 'Aprecio mucho que reconozcas esto. Significa bastante para mí.',
            'fecha' => now()->subDays(4)->format('Y-m-d'),
        ]);

        // 4. Crear momentos especiales compartidos
        Momentos::create([
            'titulo' => 'Nuestra primera cita',
            'fecha' => '2023-04-12',
            'descripcion' => 'Aquel día en el que los nervios nos ganaban, pero bastó una mirada y una conversación sincera para saber que había una conexión única. Recordar tu risa en ese café me alegra el alma.',
            'foto' => 'primera_cita.jpg',
        ]);

        Momentos::create([
            'titulo' => 'El paseo bajo la lluvia de invierno',
            'fecha' => '2023-07-24',
            'descripcion' => 'Nos olvidamos del paraguas, pero corrimos riendo a refugiarnos. A pesar del frío, estar tomados de la mano hizo que fuera uno de los días más cálidos de mi vida.',
            'foto' => 'bajo_la_lluvia.jpg',
        ]);

        Momentos::create([
            'titulo' => 'Ese atardecer frente al mirador',
            'fecha' => '2024-02-14',
            'descripcion' => 'El cielo se tiñó de colores hermosos, pero yo solo podía mirarte a ti. En ese instante de paz absoluta, entendí la suerte tan grande que tenía de compartir mi camino contigo.',
            'foto' => 'atardecer.jpg',
        ]);

        // 5. Crear valores compartidos (compromisos)
        valores_compartidos::create([
            'titulo' => 'Escucha Activa y Paciente',
            'descripcion' => 'Escuchar para comprender el corazón del otro, no para defendernos. Hablar con cariño y dar espacio mutuo.',
        ]);

        valores_compartidos::create([
            'titulo' => 'Honestidad y Confianza',
            'descripcion' => 'Ser transparentes en lo que sentimos y hacemos. Reconstruir la confianza con acciones constantes y sinceras.',
        ]);

        valores_compartidos::create([
            'titulo' => 'Tiempo y Presencia de Calidad',
            'descripcion' => 'Desconectarnos del ruido externo para conectarnos de verdad cuando estamos juntos, valorando cada instante.',
        ]);

        valores_compartidos::create([
            'titulo' => 'Apoyo y Empatía Mutua',
            'descripcion' => 'Ser el refugio seguro del otro. Celebrar los triunfos y sostenernos con amor en los momentos difíciles.',
        ]);
    }
}
