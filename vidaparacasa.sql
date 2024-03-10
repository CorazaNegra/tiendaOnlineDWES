-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2024 a las 17:02:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vidaparacasa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codigo`, `nombre`, `descripcion`, `categoria`, `precio`, `imagen`, `activo`) VALUES
('AAA00001', 'Juncus effusus Spiralis', 'Ampliamos nuestro catÃ¡logo de plantas de interior con este curioso junco de formas caprichosas y enrevesadas. El junco espiral tambiÃ©n llamado junco fino o junco de esteras es una planta de interior de esas que dan un toque, un punto de decoraciÃ³n discreto a un rincÃ³n sin vida. La Ãºnica pega en sus cuidados es el riego como luego veremos pero es una planta muy socorrida y a nuestro parecer elegante y muy estÃ©tica.', 6, 14.00, 'archivos/Juncus Effus Spiralis_150x150.jpg', 1),
('AAA00002', 'Equisetum Japonicum', 'Se le conoce popularmente con otros nombres como: Colas de caballo, caÃ±ita de agua o junquillos. El Equisetum JapÃ³nicum se trata de un helecho que pudiera considerarse como el mÃ¡s antiguo del planeta, de la especie de los Equisetum. Esta especie puede llegar a medir entre 60 centÃ­metros, incluso puede alcanzar los 5 metros de altura.', 6, 17.00, 'archivos/Equisetum_japonicum_150x150.jpg', 1),
('AAA00003', 'Hippurus Vulgaris', 'La especie Hippuris Vulgaris pertenece a la familia de las plantaginÃ¡ceas, es decir, es de las plantas de jardÃ­n del gÃ©nero de las dicotiledÃ³neas, las cuales alcanzan la cifra de unas dos mil especies. Su forma de pino otorga una vista Ãºnica para tu jardÃ­n, sobre todo en ambientes donde se puede percibir su follaje.', 6, 7.00, 'archivos/Hippuris-Vulgaris_150X150.jpg', 0),
('BBB00001', 'Arbutus Unedo', 'el madroÃ±o mide de 4 a 10 m con un tronco rojizo mÃ¡s o menos cubierto de largas escamas grisÃ¡ceas, con ramas grises y ramillas abundantemente foliosas, pardo-rojizas, a menudo piloso-glandulosas. Las hojas son persistentes, de 8 por 3 cm, y son lanceoladas, lauroides, serradas o serruladas, de un verde brillante por el haz, mates por el envÃ©s, con pecÃ­olo de hasta 7â€“8 mm. Las inflorescencias se presentan en panÃ­culas colgantes, con raquis rojizo y brÃ¡cteas ovado-lanceoladas cupuliformes envolventes, rojizas.', 7, 172.00, 'archivos/Arbutus-unendo-150x150.jpg', 1),
('BBB00002', 'Phoenix Dactylifera', 'Phoenix dactylifera, de nombre comÃºn palma datilera/datilero, palma comÃºn, fÃ©nix o tÃ¡mara, es una palmera cuyo fruto comestible es el dÃ¡til, probablemente oriunda del suroeste de Asia. Esta especie es una de las mÃ¡s notables del gÃ©nero Phoenix, que cuenta con otras quince, distribuidas desde Canarias, pasando por el norte de Ãfrica y el sur de Asia, hasta el Extremo Oriente.', 7, 11.00, 'archivos/phoenis_dactylifera-150x150.jpg', 1),
('BBB00003', 'Rosal Grandiflora', 'La rosa grandiflora o de flor grande, es un cruce entre un hÃ­brido de te y una rosa floribunda.\r\nLo que se perseguÃ­a al crear este nuevo cruce y variedad de rosas, es obtener una flor con la belleza de los hÃ­bridos de te, pero a la vez tener arbustos con una gran floraciÃ³n propia de los floribunda.\r\nAlgunas de las rosas de esta clasificaciÃ³n, se pueden incluir en hÃ­brido de te o floribunda, es lo que tienen a veces las clasificaciones de las rosas.', 7, 8.00, 'archivos/rosal-grandiflora-150X150.jpg', 1),
('CCC00001', 'Rosmarinus Oficinalis', 'GÃ©nero: Rosmarinus\r\nEspecie: officinalis\r\nFamilia: Labiadas\r\nNombre popular: Romero\r\nDistribuciÃ³n natural: Se extiende por toda la regiÃ³n mediterrÃ¡nea y Macaronesia. En la PenÃ­nsula IbÃ©rica falta en el norte. Vive en matorrales hasta los 1400 m s.n.m.\r\nHumedad: Baja o Mediana\r\nInsolaciÃ³n: sol\r\nRequerimientos edÃ¡ficos: Prefiere suelos calizos, aunque tambiÃ©n tolera los silÃ­ceos. Puede vivir en suelos pobres en nutrientes y materia orgÃ¡nica.\r\nPH: Sin tendencia limitante\r\nColor A: Azul\r\nFloraciÃ³n: Primavera OtoÃ±o Invierno\r\nPorte: Arbustivo (altura: 0,5-1,5 m; anchura: 1,5 m)\r\nHojas: Persistentes\r\nResistencia al frÃ­o: Zona 8 (-12,2 a -6,7Âº C)\r\nCaracterÃ­sticas: Arbusto muy ramificado, con las ramas densamente cubiertas de hojas lineares, coriÃ¡ceas, verde lustrosas por el anverso y blanquecinas por el reverso, debido a la abundancia de pequeÃ±os pelos blanquecinos, con el margen revoludo. Las flores, de color azul claro, nacen en inflorescencias axilares. Es una planta melÃ­fera.\r\nUsos frecuentes: Parterres de aromÃ¡ticas, macizos de arbustivas, borduras y fijaciÃ³n de taludes. Densidad de plantaciÃ³n: 3-4 plantas/m2.\r\nJardineria: Un exceso de riego puede provocar problemas fitosanitarios. En jardinerÃ­a es muy importante el uso de clones que resistan mejor las condiciones de cultivo, ya que a menudo presentan problemas fitosanitarios importantes.\r\nAgrupaciones:  AutÃ³ctonas.  Persistentes.  Perennifolias.  AromÃ¡ticas.  Adaptadas a zonas litorales.  Dunas.  GipsÃ­colas.  Medianas y setos.  Rocallas.', 8, 15.00, 'archivos/rosmarinus-officinalis.jpg', 1),
('CCC00002', 'Hierba Luisa', 'Aloysia citrodora, conocida como cedrÃ³n, cidrÃ³n, hierba luisa o verbena de Indias, es una planta de la familia Verbenaceae originaria de AmÃ©rica del Sur. Se cultiva como planta ornamental y por sus propiedades medicinales.', 8, 9.00, 'archivos/hierba-luisa150.jpg', 1),
('CCC00003', 'Tymus Moroderi', 'Thymus moroderi Pau ex MartÃ­nez 1934, el cantueso murciano o tomillo alicantino es una planta herbÃ¡cea endÃ©mica de la Comunidad Valenciana y la RegiÃ³n de Murcia, en la costa espaÃ±ola del Mar MediterrÃ¡neo, estrechamente emparentada con el tomillo comÃºn (Thymus vulgaris L.). No debe confundirse con el cantueso menor, Lavandula stoechas L., una especie de lavanda, con la que guarda algÃºn parecido a cierta distancia.', 8, 7.00, 'archivos/thymus-moroderi-150x150.jpg', 1),
('DDD00001', 'Tulipa', 'Tulipa es un gÃ©nero de plantas perennes y bulbosas perteneciente a la familia Liliaceae, en el que se incluyen los populares tulipanes, nombre comÃºn con el que se designa a todas las especies, hÃ­bridos y cultivares de este gÃ©nero. Tulipa contiene aproximadamente 150 especies e innumerables cantidades de hÃ­bridos y cultivares conseguidos a travÃ©s de mejoramiento genÃ©tico que los floricultores fueron realizando desde el siglo XVI.', 9, 5.00, 'archivos/tulipa_150x150.jpg', 1),
('DDD00002', 'Jacinto', 'El jacinto es un gÃ©nero de plantas perenne y bulbosas perteneciente a la subfamilia de las escilÃ³ideas dentro de las asparagÃ¡ceas. Es originario de la regiÃ³n mediterrÃ¡nea y Ãfrica meridional. El jacinto comÃºn u holandÃ©s y la especie de jardÃ­n H. orientalis fueron tan populares durante el siglo XVIII que se cultivaron mÃ¡s de dos tipos en los PaÃ­ses Bajos, el principal productor.', 9, 7.00, 'archivos/jacinto_150.jpg', 1),
('EEE00001', 'Aglaonema Commutatum', 'Son plantas herbÃ¡ceas perennes que alcanzan 20-150 cm de altura. Las hojas son alternas en los tallos, lanceoladas a estrechamente ovadas, oscuras o medio verdes con 10-45 cm de longitud y 10-16 cm de ancho, dependiendo de la especie. Las flores son los espÃ¡dices de color blanco o blanco verdoso que puede dar camino a las bayas rojas.', 10, 13.00, 'archivos/aglaonema1_150.jpg', 1),
('EEE00002', 'Aglaonema Costatum', 'Aglaonema es un gÃ©nero de 20 especies de plantas de flores perteneciente a la familia Araceae, nativo de las selvas tropicales hÃºmedas del sudoeste de Asia desde BangladÃ©s a Filipinas y norte y sur de China.', 10, 12.00, 'archivos/aglaonema2_150.jpg', 1),
('EEE00003', 'Aglaonema', 'Aglaonema es un gÃ©nero de 20 especies de plantas de flores perteneciente a la familia Araceae, nativo de las selvas tropicales hÃºmedas del sudoeste de Asia desde BangladÃ©s a Filipinas y norte y sur de China.', 10, 12.00, 'archivos/aglaonema3_150.jpg', 1),
('FFF00001', 'Alocasia acuminata', 'Alocasia (Schott) G.Don es un gÃ©nero de plantas con rizoma o bulbo perenne de la familia Araceae. Son nativas de las Ã¡reas tropicales y subtropicales de Asia y Australia, aunque hoy se encuentran cultivadas por todo el mundo.', 11, 11.00, 'archivos/alocasia1_150.jpg', 1),
('FFF00002', 'Alocasia longiloba', 'Alocasia (Schott) G.Don es un gÃ©nero de plantas con rizoma o bulbo perenne de la familia Araceae. Son nativas de las Ã¡reas tropicales y subtropicales de Asia y Australia, aunque hoy se encuentran cultivadas por todo el mundo.\r\n\r\nLas hojas son cordadas o sagitadas, creciendo de 2 a 9 dm sobre un largo peciolo. Sus hermosas flores son apenas visibles, ya que se encuentran ocultas entre las hojas.\r\n\r\nLos tallos son comestibles, pero contienen Ã¡cido oxÃ¡lico que puede paralizar la lengua y faringe. Para su consumo debe ser hervido prolongadamente.', 11, 19.00, 'archivos/alocasia2_150.jpg', 1),
('FFF00003', 'Alocasia puber', 'Alocasia (Schott) G.Don es un gÃ©nero de plantas con rizoma o bulbo perenne de la familia Araceae. Son nativas de las Ã¡reas tropicales y subtropicales de Asia y Australia, aunque hoy se encuentran cultivadas por todo el mundo.', 11, 14.00, 'archivos/alocasia3_150.jpg', 1),
('GGG00001', 'Calathea anderssonii', 'Calathea es un gÃ©nero de plantas de la familia Marantaceae, nativo de AmÃ©rica tropical, principalmente de Brasil y PerÃº, muchas de las especies son populares como plantas hogareÃ±as o de ornato, algunas conocidas como de la plegaria o cebra. ComprendÃ­a 287 especies aceptadas,2â€‹ pero, tras su estudio filogenÃ©tico mÃ¡s de 200 especies fueron asignadas al gÃ©nero Goeppertia.3â€‹', 12, 5.00, 'archivos/calathea1_150.jpg', 1),
('GGG00002', 'Calathea brenesii', 'Calathea es un gÃ©nero de plantas de la familia Marantaceae, nativo de AmÃ©rica tropical, principalmente de Brasil y PerÃº, muchas de las especies son populares como plantas hogareÃ±as o de ornato, algunas conocidas como de la plegaria o cebra. ComprendÃ­a 287 especies aceptadas,2â€‹ pero, tras su estudio filogenÃ©tico mÃ¡s de 200 especies fueron asignadas al gÃ©nero Goeppertia.3â€‹', 12, 6.00, 'archivos/calathea2_150.jpg', 1),
('GGG00003', 'Calathea ravenii ', 'Calathea es un gÃ©nero de plantas de la familia Marantaceae, nativo de AmÃ©rica tropical, principalmente de Brasil y PerÃº, muchas de las especies son populares como plantas hogareÃ±as o de ornato, algunas conocidas como de la plegaria o cebra. ComprendÃ­a 287 especies aceptadas,2â€‹ pero, tras su estudio filogenÃ©tico mÃ¡s de 200 especies fueron asignadas al gÃ©nero Goeppertia.3â€‹', 12, 8.00, 'archivos/calathea3_150.jpg', 1),
('HHH00001', 'Ceropegia Woodii', 'Ceropegia woodii Schltr. es una especie de planta de la familia Apocynaceae. Llamada comÃºnmente collar de corazones es una planta colgante con hojas en forma de corazÃ³n de color verde oscuro con manchas de apariencia marmÃ³rea.', 13, 21.00, 'archivos/Ceropegia Woodii150.jpg', 1),
('HHH00002', 'Photo', 'Epipremnum aureum, comÃºnmente conocido como potus, pothos, telÃ©fono o poto (antiguamente clasificado dentro del gÃ©nero Pothos y, por esto, conocido habitualmente bajo este nombre) es una especie de la familia Araceae nativa del sudeste asiÃ¡tico (Malasia, Indonesia) y Nueva Guinea. En ocasiones es confundida con philodendron en las floristerÃ­as', 13, 9.00, 'archivos/Epipremnum aureum150.jpg', 1),
('HHH00003', 'Helecho', 'Nephrolepis es un gÃ©nero botÃ¡nico de cerca de 30 especies de helechos en la familia de las Lomariopsidaceae. Son popularmente conocidos como helechos colgantes o helechos babilÃ³nicos.', 13, 11.95, 'archivos/Nephrolepsis150_2.jpg', 1),
('III00001', 'Tinaja de barro', 'Tinaja barro rojo. Barro nacional; volumen 21.8lt', 14, 31.50, 'archivos/tinaja-barro-rojo-36cm.jpg', 1),
('III00002', 'Maceta de barro grande', 'ALFAREROS DAMIAN CANOVAS Modelo Bote .1 Maceta DE Barro Medidas 17 DIAMETRO X 19ALTURA + 1PLATO DIAMETRO 18 CM', 14, 26.95, 'archivos/31XwXxlnSBS._SL160_.jpg', 1),
('III00003', 'Maceta de barro con plato', 'Las macetas de barro estÃ¡n diseÃ±adas para su uso en exterior. Tienen el peso adecuado para soportar las rachas de viento, y nos pueden durar mucho, mucho tiempo con un mantenimiento adecuado. AdemÃ¡s, las podemos personalizar como queramos. TambiÃ©n hay que aÃ±adir que al sistema radicular de las plantas les costarÃ¡ menos agarrarse en el interior de la misma, lo cual ayudarÃ¡ a que el crecimiento sea Ã³ptimo.', 14, 33.75, 'archivos/41+M1ITSfFL._SL160_.jpg', 1),
('JJJ00001', 'TrÃ­o Macetas Eco Amsterdam Gris ', 'Tres exclusivos maceteros fabricados con yute en forma de cesta, son perfecto para disfrutar de tus momentos mÃ¡s plantiferos sin perder ese toque de diseÃ±o esencial en tu vida.', 15, 17.85, 'archivos/OIP.jpg', 1),
('JJJ00002', 'Macetas orgÃ¡nicas Fertilpot', 'Maceta biodegradable fabricada con fibras vegetales.\r\n\r\nFertilpot es un recipiente biodegradable fabricado a base de fibras vegetales: 80% de fibra de madera y en un 20% de turba rubia.\r\n\r\nFertilpot es apto para distintos tipos de cultivos, se utiliza tanto en horticultura como en viveros de planta ornamental, producciÃ³n de plantones de vid y planta forestal.', 15, 15.65, 'archivos/macetas_y_contenedores_biodegradables_fertilpot-150x150.jpg', 1),
('KKK00001', 'Macetas de plÃ¡stico: con rejilla lateral', 'Contenedor para enterrar, permite el cultivo en el suelo sin necesidad de cambiarlo para la venta.', 16, 17.85, 'archivos/R.jpg', 1),
('KKK00002', 'Maceta decorativa', 'Este arriate es una excelente opciÃ³n para cultivar una variedad de flores o plantas, por lo que es un gran aporte para el jardÃ­n.', 16, 25.50, 'archivos/41GTMsvwgrL._SL160_.jpg', 1),
('LLL00001', 'ABONO 10-20-20 PRECISAGRO', 'Posee una concentraciÃ³n de nutrientes ideal para la etapa reproductiva del cultivo.\r\n\r\nDOSIS\r\nPara la venta y aplicaciÃ³n de este fertilizante, es recomendable la prescripciÃ³n de un ingeniero agrÃ³nomo con base en el anÃ¡lisis de suelos o del tejido foliar.', 17, 19.95, 'archivos/ABONO-PRECISAGRO-10-11-29-150x150.png', 1),
('LLL00002', 'Fertilizante Germinal 1 kg bolsa', 'Fertilizante granulado, balanceado y completo, que contiene los elementos necesarios para un buen desarrollo vegetativo. AdemÃ¡s de macroelementos (N, P, K), aporta un conjunto de microelementos, fundamentales, para los procesos de crecimiento, desarrollo, floraciÃ³n y sanidad de las especies vegetales.FORMA DE USOAplique alrededor de las plantas anuales y Ã¡rboles frutales, incorpore con una palita o un rastrillo, cuidando de no daÃ±ar las raÃ­ces superficiales.', 17, 10.95, 'archivos/87785.jpg', 1),
('LLL00003', 'Nutrione 1 Kg', 'Pack 5 Unidades. Nutrione, Abono Fertilizante Concentrado Premium Microgranulado para Todo Tipo Plantas, 1 Kg', 17, 33.95, 'archivos/360024_2_para-todo-tipo-plantas-1-kg-lotesgs1172.jpg', 1),
('MMM00001', 'Manguera 25mt.', 'Las tuberias de goteo, son las encargadas de llevar y distribuir el agua hasta tus plantas.', 18, 22.50, 'archivos/tuberias-accesorios-riego.jpg', 1),
('MMM00002', 'VÃ¡lvula Ramal 16 mm 50ud.', 'VÃ¡lvula ramal 16 mm, para incorporar a tu instalaciÃ³n de riego por goteo,y poder controlar por secciones el riego de tus plantas.', 18, 12.95, 'archivos/accesorio_riego-150x150.jpg', 1),
('MMM00003', 'TeflÃ³n para Conexiones de Goteo', 'TeflÃ³n, en rollo para tus instalaciones, asÃ­ puedes enrollar las  roscas, y crear tu propia instalaciÃ³n de riego por goteo.', 18, 1.15, 'archivos/TEFLON-13-20-150x150.jpg', 1),
('NNN00001', 'Llana', 'Llana fabricada en acero con mango de PVC.', 19, 7.50, 'archivos/OIP (1).jpg', 1),
('NNN00002', 'Pala Nega', 'Las palas son otra herramienta indispensable para el trabajo en jardinerÃ­a. Estos utensilios nos ayudan a realizar labores como cavar en la tierra, arrancar raÃ­ces, llenar la carreta de arena.', 19, 11.95, 'archivos/OIP (2).jpg', 1),
('NNN00003', 'Podadora', 'Esta mÃ¡quina puede ser de todo tipo de tamaÃ±os en base al uso al que se la va a destinar, pero su estructura es similar en todos los casos. Puede ser elÃ©ctrica o funcionar mediante combustible, posee en su parte inferior cuchillas para realizar un corte parejo y uniforme en el cÃ©sped.', 19, 195.50, 'archivos/Herramientas-de-jardinerÃ­a-Podadora-150x150.jpg', 1),
('OOO00001', 'Insecticidas cipermetrina 20 ml ', 'Cuida y protege tus plantas, eliminando plagas e insectos, con este insecticida muy Ãºtil para tu jardÃ­n.', 20, 6.50, 'archivos/1659200.jpg', 1),
('OOO00002', 'Ever Green Fungicida Multiefecto', 'EVER GREEN FUNGICIDA MULTIEFECTO es una fÃ³rmula eficaz contra hongos y bacterias que atacan a las plantas, listo para usar. ActÃºa de forma rÃ¡pida y sistÃ©mica, eliminando plagas difÃ­ciles de tratar en especial por exceso de humedad o falta de desinfecciÃ³n del suelo. Plagas que controla: hongos: fusariosis (Fusarium); hongo de mancha marrÃ³n (Helmitesporium); verticilosis (Verticilium); chancro (Antracnosis); fumagina (Capnodium sp.); hongo de pelusa blanca: por el revÃ©s de la hoja (Mildiu), por ambos lados de la hoja (Oidio).', 20, 14.95, 'archivos/OIP (3).jpg', 1),
('OOO00003', 'Insecticida multi efecto jardin 750ml', 'Es un insecticida 100% orgÃ¡nico utilizado para eliminar los hormigueros de las hormigas de fuego (Solenopsis).\r\n\r\nEl producto viene listo para usar. No toque el producto con las manos ya que el producto perderÃ­a su efectividad y no atraerÃ­a a las hormigas.', 20, 10.95, 'archivos/OIP (4).jpg', 1),
('PPP00001', 'Bonsai granado', 'El Bonsai de Granado en zonas de clima mediterrÃ¡neo puede situarse al exterior todo el aÃ±o.En zonas mÃ¡s frÃ­as es conveniente protegerlo en invierno sobretodo de las heladas.\r\n\r\nEdad 8 aÃ±os.', 5, 54.95, 'archivos/R (1).jpg', 1),
('PPP00002', 'BonsÃ¡i Pino', 'Edad 9 aÃ±os. Entrega de 1 a 15 dÃ­as.\r\n\r\nNombre cientÃ­fico: Pinus Halepensis', 5, 34.95, 'archivos/51iToufJL2L._SL160_.jpg', 1),
('PPP00003', 'BonsÃ¡i Pyracantha', 'El BonsÃ¡i de Pyracantha puede situarse al exterior durante todo el aÃ±o. A pleno sol durante la floraciÃ³n, en verano podemos colocarla en semisombra. Resiste muy bien el frÃ­o aunque debemos protegerla de las heladas.', 5, 44.85, 'archivos/OIP (5).jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codCategoriaPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codigo`, `nombre`, `activo`, `codCategoriaPadre`) VALUES
(1, 'Plantas Exterior', 1, NULL),
(2, 'Plantas Interior', 1, NULL),
(3, 'Macetas', 1, NULL),
(4, 'Accesorios Jardin', 1, NULL),
(5, 'Otros', 1, NULL),
(6, 'acuÃ¡ticas', 1, 1),
(7, 'arbustos', 1, 1),
(8, 'aromÃ¡ticas', 1, 1),
(9, 'bulbos', 1, 1),
(10, 'aglaonemas', 1, 2),
(11, 'alocasias', 1, 2),
(12, 'calatheas', 1, 2),
(13, 'colgantes', 1, 2),
(14, 'maceta barro', 1, 3),
(15, 'maceta ecofriendly', 1, 3),
(16, 'maceta plÃ¡stico', 1, 3),
(17, 'abono', 1, 4),
(18, 'accesorios riego', 1, 4),
(19, 'herramientas', 1, 4),
(20, 'insecticidas', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `codigoArticulo` varchar(8) NOT NULL,
  `precioUnitario` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`id`, `idPedido`, `codigoArticulo`, `precioUnitario`, `cantidad`, `estado`) VALUES
(6, 62, 'AAA00002', 17.00, 1, 'Cancelado'),
(7, 62, 'BBB00001', 172.00, 1, 'Cancelado'),
(8, 62, 'BBB00002', 11.00, 1, 'Cancelado'),
(9, 63, 'CCC00001', 15.00, 1, 'Cancelado'),
(10, 63, 'OOO00002', 14.95, 1, 'Cancelado'),
(11, 63, 'PPP00001', 54.95, 1, 'Cancelado'),
(12, 64, 'CCC00001', 15.00, 1, 'Cancelado'),
(13, 64, 'III00002', 26.95, 1, 'Cancelado'),
(14, 65, 'BBB00001', 172.00, 1, 'Cancelado'),
(15, 65, 'BBB00002', 11.00, 1, 'Cancelado'),
(16, 65, 'BBB00003', 8.00, 1, 'Cancelado'),
(17, 66, 'BBB00001', 172.00, 3, 'Cancelado'),
(18, 67, 'AAA00001', 14.00, 1, 'Cancelado'),
(19, 67, 'BBB00002', 11.00, 1, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `claveTransaccion` varchar(255) NOT NULL,
  `paypalDatos` text DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `codUsuario` varchar(9) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `claveTransaccion`, `paypalDatos`, `fecha`, `codUsuario`, `total`, `estado`) VALUES
(62, 'ehfasj0i9r9ejsl00tcf3t5lbs', NULL, '2024-03-04 17:20:40', '21457890V', 200.00, 'Pago confirmado'),
(63, 'ehfasj0i9r9ejsl00tcf3t5lbs', NULL, '2024-03-04 17:21:02', '21457890V', 84.90, 'Pago confirmado'),
(64, 'ehfasj0i9r9ejsl00tcf3t5lbs', NULL, '2024-03-04 17:22:05', '74859612V', 41.95, 'Pago confirmado'),
(65, 'r01d2ta6hnh22nep2o62pj432j', NULL, '2024-03-04 19:06:32', '21457890V', 191.00, 'Pago confirmado'),
(66, 'r01d2ta6hnh22nep2o62pj432j', NULL, '2024-03-04 19:07:36', '33547895A', 516.00, 'Pago confirmado'),
(67, 'cdpi8sgsg3fc9nrka0j96t7ebp', NULL, '2024-03-08 19:42:12', '33547895A', 25.00, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'usuario',
  `clave_usuario` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `nombre`, `apellidos`, `direccion`, `localidad`, `provincia`, `telefono`, `email`, `rol`, `clave_usuario`, `activo`) VALUES
('11111111H', 'Julian', 'Torres Rotas', 'avenida de los robles, 2213', 'Pasadena', 'California', '963852741', 'micorreo@gmail.com', 'usuario', '$2y$10$0VCZRt1iTpwZ6P9t7nzc4eANAGHWa00Lknz2q6D94xW3dDg4RC.ua', 1),
('21457890V', 'Jacinto', 'Torres Palacios', 'c/ Las Bayas, s/n', 'Pacheta', 'Murcia', '699977788', 'jacinto@sudominio.com', 'admin', '$2y$10$Vrd6OlDXtHAh3pNwBIezkuq4O1Dk1UA7qDeO0R/DJuY4iwAU.xCZO', 1),
('33547895A', 'Pablo', 'Puentes Largos', 'Avenida de los robles, s/n', 'Pasadena', 'Albacete', '698521748', 'pablo@sudominio.com', 'usuario', '$2y$10$Eb4Cby.0feRg1ZgHCrsyI.u98J38MlUC8hDUadxRfsSYbwEC7ttde', 1),
('74859612V', 'Helena', 'Carrera Corta', 'Camino de los arroyos, s/n', 'Benajuzar', 'Alicante', '698741325', 'helena@sudominio.es', 'empleado', '$2y$10$mtE687.hIblR39DH8/uUpe9OJ0JNY9YZpAPFAvWPofjngEC3KXq6.', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codCategoriaPadre` (`codCategoriaPadre`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `codigoArticulo` (`codigoArticulo`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `codUsuario` (`codUsuario`),
  ADD KEY `idx_estado` (`estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`codCategoriaPadre`) REFERENCES `categorias` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`codigoArticulo`) REFERENCES `articulos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallepedido_ibfk_3` FOREIGN KEY (`estado`) REFERENCES `pedidos` (`estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
