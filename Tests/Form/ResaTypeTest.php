<?php
 // tests/Form/Type/TestedTypeTest.php
namespace App\Tests\Form;


use App\Entity\Resa;
use App\Form\ResaType;
use Symfony\Component\Form\Test\TypeTestCase;

class ResaTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'visitDate' => "2019-02-25",
            'emailResa' => 'admin@test.de',
            'typeTicket' => true,
            'nbTickets' => 2
        ];

        $objectToCompare = new Resa();
        // $objectToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ResaType::class, $objectToCompare);

        $object = new Resa();
        $date = new \DateTime('2019-02-25');
        $object->setVisitDate($date)
            ->setEmailResa('admin@test.de')
            ->setTypeTicket(true)
            ->setNbTickets(2);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $objectToCompare was modified as expected when the form was submitted
        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
