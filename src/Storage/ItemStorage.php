<?php

declare(strict_types=1);

namespace App\Storage;

use Redis;
use Redis\Graph;
use Redis\Graph\Edge;
use Redis\Graph\Node;

class ItemStorage
{
    public function __construct(private Redis $redis)
    {
    }

    public function removeGraph(): void
    {
        $graph = $this->getGraph();

        $graph->delete();
    }

    public function getInventory(string $itemName = null): void
    {
        $graph = $this->getGraph();

        $query = 'MATCH (i:item)-[r:hasType]->(t:type) RETURN i.name, i.baseValue, i.description, t.name';

        $result = $graph->query($query);

        $result->prettyPrint();
    }

    public function create(): void
    {

        foreach ($this->mockItemData() as $item) {
            $graph = $this->getGraph();

            $graph->addNode(
                $itemNode = new Node('item', $item['item'])
            );

            $graph->addNode(
                $typeNode = new Node('type', $item['type'])
            );

            $typeEdge = new Edge($itemNode, $typeNode, 'hasType');
            $graph->addEdge($typeEdge);

            $graph->commit();
        }
    }

    public function getGraph(): Graph
    {
        return new Graph('Inventory', $this->redis);
    }

    private function mockItemData(): array
    {
        return [
            'item-1' => [
                'item' => [
                    'name' => 'Spade',
                    'baseValue' => 200,
                    'description' => 'Perfect for burying or excavating.',
                ],
                'relation' => 'hasType',
                'type' => [
                    'name' => 'Miscellaneous'
                ]
            ],
            'item-2' => [
                'item' => [
                    'name' => 'Fishing Rod',
                    'baseValue' => 50,
                    'description' => 'A stout fishing rod. Where there is water, there is fish.',
                ],
                'relation' => 'hasType',
                'type' => [
                    'name' => 'Miscellaneous'
                ]
            ],
            'item-3' => [
                'item' => [
                    'name' => 'Elixir of Life',
                    'baseValue' => null,
                    'description' => 'A rare herbal potion, with extraordinary health-boosting powers. Become more healthy than you have ever been before!',
                ],
                'relation' => 'hasType',
                'type' => [
                    'name' => 'Potion'
                ]
            ],
            'item-4' => [
                'item' => [
                    'name' => 'Ages of Might Potion',
                    'baseValue' => 300,
                    'description' => 'Drinking from this beverage will increase your Strength Experience.',
                ],
                'relation' => 'hasType',
                'type' => [
                    'name' => 'Potion'
                ]
            ],
            'item-5' => [
                'item' => [
                    'name' => 'Avo\'s Tear',
                    'baseValue' => 126250,
                    'damage' => 230,
                    'description' => 'This Sword was imbued with extraordinary power when the Guild Mage Solcius used it in a spell to close a large vortex. For a long time, it has existed only as a myth among acolytes.',
                ],
                'relation' => 'hasType',
                'type' => [
                    'name' => 'Longsword'
                ]
            ],
        ];
    }
}
