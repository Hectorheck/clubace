<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regiones;
use App\Models\Comunas;

class RegionesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Regiones::create(['nombre' => 'Tarapacá', 'codigo' => 'I']);
		Regiones::create(['nombre' => 'Antofagasta', 'codigo' => 'II']);
		Regiones::create(['nombre' => 'Atacama', 'codigo' => 'III']);
		Regiones::create(['nombre' => 'Coquimbo', 'codigo' => 'IV']);
		Regiones::create(['nombre' => 'Valparaíso', 'codigo' => 'V']);
		Regiones::create(['nombre' => "O' Higgins", 'codigo' => 'VI']);
		Regiones::create(['nombre' => 'Maule', 'codigo' => 'VII']);
		Regiones::create(['nombre' => 'Biobío', 'codigo' => 'VIII']);
		Regiones::create(['nombre' => 'Araucanía', 'codigo' => 'IX']);
		Regiones::create(['nombre' => 'Los Lagos', 'codigo' => 'X']);
		Regiones::create(['nombre' => 'Aysén', 'codigo' => 'XI']);
		Regiones::create(['nombre' => 'Magallanes', 'codigo' => 'XII']);
		Regiones::create(['nombre' => 'Metropolitana', 'codigo' => 'RM']);
		Regiones::create(['nombre' => 'Los Ríos', 'codigo' => 'XIV']);
		Regiones::create(['nombre' => 'Arica y Parinacota', 'codigo' => 'XV']);
		Regiones::create(['nombre' => 'Ñuble', 'codigo' => 'XVI']);

		Comunas::create(['nombre' => 'Iquique','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Alto Hospicio','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Pozo Almonte','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Camina','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Colchane','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Huara','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Pica','regiones_id' => 1]);
		Comunas::create(['nombre' => 'Antofagasta','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Mejillones','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Sierra Gorda','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Taltal','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Calama','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Ollagüe','regiones_id' => 2]);
		Comunas::create(['nombre' => 'San Pedro de Atacama','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Tocopilla','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Maria Elena','regiones_id' => 2]);
		Comunas::create(['nombre' => 'Copiapo','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Caldera','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Tierra Amarilla','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Chañaral','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Diego de Almagro','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Vallenar','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Alto del Carmen','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Freirina','regiones_id' => 3]);
		Comunas::create(['nombre' => 'Huasco','regiones_id' => 3]);
		Comunas::create(['nombre' => 'La Serena','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Coquimbo','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Andacollo','regiones_id' => 4]);
		Comunas::create(['nombre' => 'La Higuera','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Paiguano','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Vicuña','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Illapel','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Canela','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Los Vilos','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Salamanca','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Ovalle','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Combarbala','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Monte Patria','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Punitaqui','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Rio Hurtado','regiones_id' => 4]);
		Comunas::create(['nombre' => 'Valparaiso','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Casablanca','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Concon','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Juan Fernandez','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Puchuncavi','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Quintero','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Viña del Mar','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Isla de Pascua','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Los Andes','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Calle Larga','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Rinconada','regiones_id' => 5]);
		Comunas::create(['nombre' => 'San Esteban','regiones_id' => 5]);
		Comunas::create(['nombre' => 'La Ligua','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Cabildo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Papudo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Petorca','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Zapallar','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Quillota','regiones_id' => 5]);
		Comunas::create(['nombre' => 'La Calera','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Hijuelas','regiones_id' => 5]);
		Comunas::create(['nombre' => 'La Cruz','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Nogales','regiones_id' => 5]);
		Comunas::create(['nombre' => 'San Antonio','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Algarrobo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Cartagena','regiones_id' => 5]);
		Comunas::create(['nombre' => 'El Quisco','regiones_id' => 5]);
		Comunas::create(['nombre' => 'El Tabo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Santo Domingo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'San Felipe','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Catemu','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Llaillay','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Panquehue','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Putaendo','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Santa Maria','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Limache','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Quilpue','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Villa Alemana','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Olmue','regiones_id' => 5]);
		Comunas::create(['nombre' => 'Rancagua','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Codegua','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Coinco','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Coltauco','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Graneros','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Doñihue','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Las Cabras','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Machali','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Malloa','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Mostazal','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Olivar','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Peumo','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Pichidegua','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Quinta de Tilcoco','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Rengo','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Requinoa','regiones_id' => 6]);
		Comunas::create(['nombre' => 'San Vicente','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Pichilemu','regiones_id' => 6]);
		Comunas::create(['nombre' => 'La Estrella','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Litueche','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Marchigue','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Navidad','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Paredones','regiones_id' => 6]);
		Comunas::create(['nombre' => 'San Fernando','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Chepica','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Chimbarongo','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Lolol','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Nancagua','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Palmilla','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Peralillo','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Pumanque','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Santa Cruz','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Placilla','regiones_id' => 6]);
		Comunas::create(['nombre' => 'Talca','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Constitucion','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Curepto','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Empedrado','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Maule','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Pelarco','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Pencahue','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Rio Claro','regiones_id' => 7]);
		Comunas::create(['nombre' => 'San Clemente','regiones_id' => 7]);
		Comunas::create(['nombre' => 'San Rafael','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Cauquenes','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Chanco','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Pelluhue','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Curico','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Hualañe','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Licanten','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Molina','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Rauco','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Romeral','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Sagrada Familia','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Teno','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Vichuquen','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Linares','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Colbun','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Longavi','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Parral','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Retiro','regiones_id' => 7]);
		Comunas::create(['nombre' => 'San Javier','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Villa Alegre','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Yerbas Buenas','regiones_id' => 7]);
		Comunas::create(['nombre' => 'Concepcion','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Coronel','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Chiguayante','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Florida','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Hualqui','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Lota','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Penco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'San Pedro de la Paz','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Santa Juana','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Talcahuano','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Tome','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Hualpen','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Lebu','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Arauco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Canete','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Contulmo','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Curanilahue','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Los Alamos','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Tirua','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Los Angeles','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Antuco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Cabrero','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Laja','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Mulchen','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Nacimiento','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Negrete','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Quilaco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Quilleco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'San Rosendo','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Santa Barbara','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Tucapel','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Yumbel','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Alto Biobio','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Chillan','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Cobquecura','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Chillan Viejo','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Ninhue','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Ñiquen','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Pinto','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Portezuelo','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Ranquil','regiones_id' => 8]);
		Comunas::create(['nombre' => 'San Fabian','regiones_id' => 8]);
		Comunas::create(['nombre' => 'San Ignacio','regiones_id' => 8]);
		Comunas::create(['nombre' => 'San Nicolas','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Treguaco','regiones_id' => 8]);
		Comunas::create(['nombre' => 'Temuco','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Carahue','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Cunco','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Curarrehue','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Freire','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Galvarino','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Gorbea','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Lautaro','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Loncoche','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Melipeuco','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Nueva Imperial','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Padre Las Casas','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Perquenco','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Pitrufquen','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Pucon','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Puerto Saavedra','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Teodoro Schmidt','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Tolten','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Vilcun','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Villarrica','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Cholchol','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Angol','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Collipulli','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Curacautin','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Ercilla','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Lonquimay','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Los Sauces','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Lumaco','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Puren','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Renaico','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Traiguen','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Victoria','regiones_id' => 9]);
		Comunas::create(['nombre' => 'Puerto Montt','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Calbuco','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Cochamo','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Fresia','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Frutillar','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Los Muermos','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Llanquihue','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Maullin','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Puerto Varas','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Castro','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Ancud','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Chonchi','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Curaco de Velez','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Dalcahue','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Puqueldon','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Queilen','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Quellon','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Quemchi','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Quinchao','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Osorno','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Puerto Octay','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Purranque','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Puyehue','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Rio Negro','regiones_id' => 10]);
		Comunas::create(['nombre' => 'San Juan de la Costa','regiones_id' => 10]);
		Comunas::create(['nombre' => 'San Pablo','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Chaiten','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Futaleufu','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Hualaihue','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Palena','regiones_id' => 10]);
		Comunas::create(['nombre' => 'Coyhaique','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Lago Verde','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Aysen','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Cisnes','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Guaitecas','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Cochrane','regiones_id' => 11]);
		Comunas::create(['nombre' => "O'Higgins",'regiones_id' => 11]);
		Comunas::create(['nombre' => 'Tortel','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Chile Chico','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Rio Ibañez','regiones_id' => 11]);
		Comunas::create(['nombre' => 'Punta Arenas','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Laguna Blanca','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Rio Verde','regiones_id' => 12]);
		Comunas::create(['nombre' => 'San Gregorio','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Cabo de Hornos','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Antartica','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Porvenir','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Primavera','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Timaukel','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Natales','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Torres del Paine','regiones_id' => 12]);
		Comunas::create(['nombre' => 'Santiago','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Cerrillos','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Cerro Navia','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Conchali','regiones_id' => 13]);
		Comunas::create(['nombre' => 'El Bosque','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Estacion Central','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Huechuraba','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Independencia','regiones_id' => 13]);
		Comunas::create(['nombre' => 'La Cisterna','regiones_id' => 13]);
		Comunas::create(['nombre' => 'La Florida','regiones_id' => 13]);
		Comunas::create(['nombre' => 'La Granja','regiones_id' => 13]);
		Comunas::create(['nombre' => 'La Pintana','regiones_id' => 13]);
		Comunas::create(['nombre' => 'La Reina','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Las Condes','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Lo Barnechea','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Lo Espejo','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Lo Prado','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Macul','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Maipu','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Ñuñoa','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Pedro Aguirre Cerda','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Peñalolen','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Providencia','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Pudahuel','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Quilicura','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Quinta Normal','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Recoleta','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Renca','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Joaquin','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Miguel','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Ramon','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Vitacura','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Puente Alto','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Pirque','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Jose de Maipo','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Colina','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Lampa','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Tiltil','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Bernardo','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Buin','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Calera de Tango','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Paine','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Melipilla','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Alhue','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Curacavi','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Maria Pinto','regiones_id' => 13]);
		Comunas::create(['nombre' => 'San Pedro','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Talagante','regiones_id' => 13]);
		Comunas::create(['nombre' => 'El Monte','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Isla de Maipo','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Padre Hurtado','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Peñaflor','regiones_id' => 13]);
		Comunas::create(['nombre' => 'Valdivia','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Corral','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Lanco','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Los Lagos','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Mafil','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Mariquina','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Paillaco','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Panguipulli','regiones_id' => 14]);
		Comunas::create(['nombre' => 'La Union','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Futrono','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Lago Ranco','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Rio Bueno','regiones_id' => 14]);
		Comunas::create(['nombre' => 'Arica','regiones_id' => 15]);
		Comunas::create(['nombre' => 'Camarones','regiones_id' => 15]);
		Comunas::create(['nombre' => 'Putre','regiones_id' => 15]);
		Comunas::create(['nombre' => 'General Lagos','regiones_id' => 15]);
		Comunas::create(['nombre' => 'San Carlos','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Coihueco','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Bulnes','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Yungay','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Quillon','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Coelemu','regiones_id' => 16]);
		Comunas::create(['nombre' => 'El Carmen','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Quirihue','regiones_id' => 16]);
		Comunas::create(['nombre' => 'Pemuco','regiones_id' => 16]);
	}
}
