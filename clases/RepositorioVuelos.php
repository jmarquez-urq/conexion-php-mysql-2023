<?php
require_once 'Repositorio.php';
require_once 'Usuario.php';
require_once 'Vuelo.php';
require_once 'Aeropuerto.php';

class RepositorioVuelos extends Repositorio
{
    /**
     * Retorna un array compuesto por todos los objetos vuelo en los que el
     * código del aeropuerto de destino sea el recibido por parámetro. Si el
     * parámetro es null, el array retornado contendrá todos los vuelos.
     *
     * @param string $filtro El código de tres letras del aeropuerto destino.
     *
     * @return Array Un array en el que cada uno de sus elementos es un objeto
     *               de la clase Vuelo. Contendrá todos los vuelos en los que el
     *               código del aeropuerto de destino sea $filtro. Si $filtro
     *               es null, el array contendrá todos los vuelos de la tabla.
     */
    public function get_all($filtro = null)
    {
        // Guardamos el texto de la query en la variable $sql.
		$sql = "SELECT ";
		$sql.= "    v.id, v.duracion, v.id_usuario, ";
		$sql.= "    o.nombre, o.codigo, o.pais, ";
		$sql.= "    d.nombre, d.codigo, d.pais ";
		$sql.= "FROM vuelos v ";
		$sql.= "INNER JOIN aeropuertos o ON v.id_aeropuerto_origen = o.id ";
		$sql.= "INNER JOIN aeropuertos d ON v.id_aeropuerto_destino = d.id ";

        if ($filtro) {
            // Si el filtro NO es nulo, agregamos el WHERE.
            $sql .= "WHERE d.codigo = ? ";
        }
		$sql.= "ORDER BY v.id;";

		$query = self::$conexion->prepare($sql);

        if ($filtro) {
            // Si el filtro NO es nulo, relacionamos $filtro con el parámetro"?"
            $query->bind_param("s", $filtro);
        }

        if ($query->execute()) {
            // Ejecutamos la query, e indicamos que guardaremos los resultados
            // obtenidos en cada registro en las siguientes 9 variables:
            $query->bind_result($id, $duracion, $id_usuario,
                $nombre_o, $cod_o, $pais_o,
                $nombre_d, $cod_d, $pais_d
            );

            // Generamos un array vacío:
            $vuelos = [];

            // El siguiente bucle nos permite recorrer uno a uno los registros
            // que haya devuelto el SELECT ejecutado en $query.
            while ($query->fetch()) {
                // Con cada uno de los registros, creamos un objeto Aeropuerto
                // para el origen y otro para el destino...
                $o = new Aeropuerto($nombre_o, $cod_o, $pais_o);
                $d = new Aeropuerto($nombre_d, $cod_d, $pais_d);

                // ... y con esos dos aeropuertos creamos el objeto Vuelo...
                $v = new Vuelo($id, $duracion, $id_usuario, $o, $d);

                // ... y lo agregamos al final del array $vuelos.
                $vuelos[] = $v;
            }

            // Una vez que hemos recorrido todos los registros que devolvió el
            // SELECT, retornamos el Array $vuelos:
            return $vuelos;
        }
    }
}
