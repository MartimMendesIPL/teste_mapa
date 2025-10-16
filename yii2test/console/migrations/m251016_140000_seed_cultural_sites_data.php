<?php

use yii\db\Migration;

/**
 * Handles seeding sample data for table `{{%cultural_sites}}`.
 */
class m251016_140000_seed_cultural_sites_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();

        // Sample cultural sites across Portugal
        $sites = [
            // Lisboa
            [
                'name' => 'Torre de Belém',
                'description' => 'Torre de defesa do século XVI, Património Mundial da UNESCO. Construída no reinado de D. Manuel I, é um dos monumentos mais emblemáticos de Portugal.',
                'type' => 'monument',
                'latitude' => 38.6916,
                'longitude' => -9.2160,
                'address' => 'Av. Brasília, 1400-038 Lisboa',
                'phone' => '+351 21 362 0034',
                'website' => 'http://www.torrebelem.pt',
                'opening_hours' => '10h-18h30 (Out-Abr até 17h30)',
                'city' => 'Lisboa',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Mosteiro dos Jerónimos',
                'description' => 'Obra-prima da arquitetura manuelina, Património Mundial da UNESCO. Construído no século XVI, é um dos monumentos mais visitados de Portugal.',
                'type' => 'monument',
                'latitude' => 38.6977,
                'longitude' => -9.2062,
                'address' => 'Praça do Império 1400-206 Lisboa',
                'phone' => '+351 21 362 0034',
                'website' => 'http://www.mosteirojeronimos.pt',
                'opening_hours' => '10h-18h30 (Out-Abr até 17h30)',
                'city' => 'Lisboa',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Museu Nacional de Arte Antiga',
                'description' => 'O maior e mais importante museu de arte em Portugal. Alberga uma vasta coleção de pintura, escultura e artes decorativas portuguesas e europeias.',
                'type' => 'museum',
                'latitude' => 38.7040,
                'longitude' => -9.1627,
                'address' => 'Rua das Janelas Verdes, 1249-017 Lisboa',
                'phone' => '+351 21 391 2800',
                'website' => 'http://www.museudearteantiga.pt',
                'opening_hours' => '10h-18h (Seg fechado)',
                'city' => 'Lisboa',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Castelo de São Jorge',
                'description' => 'Castelo medieval no topo da colina de Lisboa, oferecendo vistas panorâmicas sobre a cidade. Remonta ao século XI.',
                'type' => 'monument',
                'latitude' => 38.7139,
                'longitude' => -9.1334,
                'address' => 'Rua de Santa Cruz do Castelo, 1100-129 Lisboa',
                'phone' => '+351 21 880 0620',
                'website' => 'http://www.castelodesaojorge.pt',
                'opening_hours' => '9h-21h (Nov-Fev até 18h)',
                'city' => 'Lisboa',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'MAAT - Museu de Arte, Arquitetura e Tecnologia',
                'description' => 'Museu contemporâneo dedicado à arte, arquitetura e tecnologia, com arquitetura impressionante à beira do Tejo.',
                'type' => 'museum',
                'latitude' => 38.6957,
                'longitude' => -9.2053,
                'address' => 'Av. Brasília, Central Tejo, 1300-598 Lisboa',
                'phone' => '+351 21 002 8130',
                'website' => 'https://www.maat.pt',
                'opening_hours' => '11h-19h (Ter fechado)',
                'city' => 'Lisboa',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Porto
            [
                'name' => 'Torre dos Clérigos',
                'description' => 'Torre barroca do século XVIII, símbolo do Porto. Com 75 metros de altura, oferece vistas espetaculares sobre a cidade.',
                'type' => 'monument',
                'latitude' => 41.1459,
                'longitude' => -8.6144,
                'address' => 'Rua de São Filipe de Nery, 4050-546 Porto',
                'phone' => '+351 22 014 5489',
                'website' => 'http://www.torredosclerigos.pt',
                'opening_hours' => '9h-19h',
                'city' => 'Porto',
                'region' => 'Porto',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Museu Serralves',
                'description' => 'Museu de arte contemporânea em edifício modernista, rodeado por magníficos jardins e parque.',
                'type' => 'museum',
                'latitude' => 41.1594,
                'longitude' => -8.6597,
                'address' => 'Rua Dom João de Castro 210, 4150-417 Porto',
                'phone' => '+351 22 615 6500',
                'website' => 'https://www.serralves.pt',
                'opening_hours' => '10h-19h (Seg fechado)',
                'city' => 'Porto',
                'region' => 'Porto',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Palácio da Bolsa',
                'description' => 'Edifício neoclássico do século XIX, antiga sede da Bolsa de Valores do Porto. Destaque para o Salão Árabe.',
                'type' => 'cultural_site',
                'latitude' => 41.1411,
                'longitude' => -8.6155,
                'address' => 'Rua Ferreira Borges, 4050-253 Porto',
                'phone' => '+351 22 339 9000',
                'website' => 'http://www.palaciodabolsa.com',
                'opening_hours' => '9h-18h30',
                'city' => 'Porto',
                'region' => 'Porto',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Livraria Lello',
                'description' => 'Uma das livrarias mais bonitas do mundo, com arquitetura neogótica do início do século XX.',
                'type' => 'cultural_site',
                'latitude' => 41.1467,
                'longitude' => -8.6147,
                'address' => 'Rua das Carmelitas 144, 4050-161 Porto',
                'phone' => '+351 22 200 2037',
                'website' => 'https://www.livrarialello.pt',
                'opening_hours' => '9h30-19h',
                'city' => 'Porto',
                'region' => 'Porto',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Coimbra
            [
                'name' => 'Universidade de Coimbra',
                'description' => 'Uma das universidades mais antigas da Europa (1290), Património Mundial da UNESCO. Inclui a famosa Biblioteca Joanina.',
                'type' => 'cultural_site',
                'latitude' => 40.2074,
                'longitude' => -8.4274,
                'address' => 'Paço das Escolas, 3004-531 Coimbra',
                'phone' => '+351 239 859 900',
                'website' => 'https://www.uc.pt',
                'opening_hours' => '9h-19h30',
                'city' => 'Coimbra',
                'region' => 'Coimbra',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Mosteiro de Santa Clara-a-Velha',
                'description' => 'Ruínas de um mosteiro gótico do século XIV, recuperado após séculos submerso pelas águas do Mondego.',
                'type' => 'monument',
                'latitude' => 40.2022,
                'longitude' => -8.4390,
                'address' => 'Rua das Parreiras, 3040-266 Coimbra',
                'phone' => '+351 239 801 160',
                'website' => 'http://www.santaclaravelha.pt',
                'opening_hours' => '10h-19h (Nov-Mar até 18h)',
                'city' => 'Coimbra',
                'region' => 'Coimbra',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Évora
            [
                'name' => 'Templo Romano de Évora',
                'description' => 'Templo romano do século I, um dos mais bem preservados da Península Ibérica. Património Mundial da UNESCO.',
                'type' => 'monument',
                'latitude' => 38.5742,
                'longitude' => -7.9073,
                'address' => 'Largo do Conde de Vila Flor, 7000-863 Évora',
                'phone' => '+351 266 777 071',
                'opening_hours' => 'Acesso livre',
                'city' => 'Évora',
                'region' => 'Alentejo',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Capela dos Ossos',
                'description' => 'Capela decorada com ossos e caveiras humanas, construída no século XVII. Famosa pela sua inscrição: "Nós ossos que aqui estamos pelos vossos esperamos".',
                'type' => 'cultural_site',
                'latitude' => 38.5727,
                'longitude' => -7.9078,
                'address' => 'Praça 1º de Maio, 7000-650 Évora',
                'phone' => '+351 266 704 521',
                'opening_hours' => '9h-18h30',
                'city' => 'Évora',
                'region' => 'Alentejo',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Sintra
            [
                'name' => 'Palácio da Pena',
                'description' => 'Palácio romântico colorido do século XIX, Património Mundial da UNESCO. Exemplo do Romantismo português.',
                'type' => 'monument',
                'latitude' => 38.7876,
                'longitude' => -9.3905,
                'address' => 'Estrada da Pena, 2710-609 Sintra',
                'phone' => '+351 21 923 7300',
                'website' => 'https://www.parquesdesintra.pt',
                'opening_hours' => '9h30-19h (Nov-Fev até 18h)',
                'city' => 'Sintra',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Quinta da Regaleira',
                'description' => 'Quinta com palácio, capela e jardins luxuriantes, conhecida pelo Poço Iniciático e simbolismo esotérico.',
                'type' => 'cultural_site',
                'latitude' => 38.7960,
                'longitude' => -9.3960,
                'address' => 'Rua Barbosa do Bocage 5, 2710-567 Sintra',
                'phone' => '+351 21 910 6650',
                'website' => 'https://www.regaleira.pt',
                'opening_hours' => '9h30-19h (Nov-Jan até 18h)',
                'city' => 'Sintra',
                'region' => 'Lisboa',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Guimarães
            [
                'name' => 'Castelo de Guimarães',
                'description' => 'Castelo medieval do século X, berço da nacionalidade portuguesa. Associado à fundação de Portugal.',
                'type' => 'monument',
                'latitude' => 41.4467,
                'longitude' => -8.2914,
                'address' => 'Rua Conde D. Henrique, 4810-245 Guimarães',
                'phone' => '+351 253 412 273',
                'opening_hours' => '10h-18h',
                'city' => 'Guimarães',
                'region' => 'Braga',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Braga
            [
                'name' => 'Bom Jesus do Monte',
                'description' => 'Santuário com escadaria monumental barroca e vistas panorâmicas. Património Mundial da UNESCO.',
                'type' => 'cultural_site',
                'latitude' => 41.5547,
                'longitude' => -8.3770,
                'address' => 'Estrada do Bom Jesus, 4715-056 Braga',
                'phone' => '+351 253 676 636',
                'website' => 'http://www.bomjesus.pt',
                'opening_hours' => '8h-20h',
                'city' => 'Braga',
                'region' => 'Braga',
                'created_at' => $time,
                'updated_at' => $time,
            ],

            // Faro
            [
                'name' => 'Centro Histórico de Faro',
                'description' => 'Centro histórico medieval com muralhas, Sé Catedral e diversos monumentos do período romano ao século XVIII.',
                'type' => 'cultural_site',
                'latitude' => 37.0174,
                'longitude' => -7.9304,
                'address' => 'Largo da Sé, 8000-138 Faro',
                'opening_hours' => 'Acesso livre',
                'city' => 'Faro',
                'region' => 'Algarve',
                'created_at' => $time,
                'updated_at' => $time,
            ],
        ];

        foreach ($sites as $site) {
            $this->insert('{{%cultural_sites}}', $site);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%cultural_sites}}');
    }
}
