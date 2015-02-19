<?php

use Illuminate\Database\Seeder;
use App\Configuracion;
class ConfiguracionTableSeeder extends Seeder {

    public function run() {
        Configuracion::set('impuesto', 12, 'Porcentaje Impuesto (IVA)',false);
        Configuracion::set('condiciones_presupuesto', '<p>Condiciones Generales</p>
        <ol style="text-align: justify;">
            <li>Esta oferta tiene una vigencia de 8 dias</li>
            <li>El combustible corre por cuenta nuestra</li>
            <li><strong>Condiciones de Pago: CONTADO 100% AL APROBAR EL PRESUPUESTO</strong></li>
            <li>El operador debe estar debidamente acreditado para tener acceso a las áreas donde se esta prestando servicio</li>
            <li>Las plantas eléctricas deben funcionar a un rango mínimo de 65%, de su capacidad nominal, ya que de no cumplirse este requisito podrian presentarse fallas en el equipo</li>
        </ol>
        <p>
            Abraham Oviedo<br>
            Director de Operaciones<br>
            Teléfonos: 0414-3134858
        </p>', 'Condiciones del presupuesto', true);
        Configuracion::set('footer_presupuesto', '<p style="text-align: center; color: blue;">
            Calle 3ra. trans. De Monte Cristo, No. 17, Urb. Monte Cristo, Casa Sta. Eduviges, Caracas 1020. Tel oficina 0212-2322394. Tel móvil: 0414-3134858 Fax: 0212-6352396.<br><a href="http://www.amsrental.com">www.amsrental.com</a>
        </p>', 'Pie de página del presupuesto', true);
    }

}
