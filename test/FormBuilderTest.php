<?php

namespace Estey\FormBuilder\Test;

use Mockery as m;
use Estey\FormBuilder\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Symfony\Component\Routing\RouteCollection;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $this->urlGenerator = new UrlGenerator(
            new RouteCollection,
            Request::create('/foo', 'GET')
        );
        $this->htmlBuilder = new HtmlBuilder($this->urlGenerator);
        $this->translator = m::mock('Illuminate\Translation\Translator');
        $this->formBuilder =  new FormBuilder(
            $this->htmlBuilder,
            $this->urlGenerator,
            '',
            $this->translator
        );
    }

    /**
     * Destroy the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test select() method.
     */
    public function testSelect()
    {
        $select = $this->formBuilder->select(
            'size',
            ['L' => 'Large', 'S' => 'Small']
        );

        $this->assertEquals(
            $select,
            '<select name="size"><option value="L">Large</option>' .
            '<option value="S">Small</option></select>'
        );

        $select = $this->formBuilder->select(
            'size',
            ['L' => 'Large', 'S' => 'Small'],
            'L'
        );

        $this->assertEquals(
            $select,
            '<select name="size"><option value="L" selected="selected">' .
            'Large</option><option value="S">Small</option></select>'
        );


        $select = $this->formBuilder->select(
            'size',
            ['L' => 'Large', 'S' => 'Small'],
            null,
            ['class' => 'class-name', 'id' => 'select-id']
        );

        $this->assertEquals(
            $select,
            '<select class="class-name" id="select-id" name="size">' .
            '<option value="L">Large</option><option value="S">Small' .
            '</option></select>'
        );

        $select = $this->formBuilder->select(
            'size',
            ['L' => 'Large', 'S' => 'Small'],
            '',
            [
                'class' => 'class-name',
                'id' => 'select-id',
                '_prepend' => ['' => 'Choose a Size']
            ]
        );

        $this->assertEquals(
            $select,
            '<select class="class-name" id="select-id" name="size">' .
            '<option value="" selected="selected">Choose a Size</option>' .
            '<option value="L">Large</option><option value="S">Small</option>' .
            '</select>'
        );
    }

    /**
     * Test selectMonth() method.
     */
    public function testFormSelectMonth()
    {
        $this->translator
            ->shouldReceive('has')
            ->times(12*4)
            ->andReturn(false);

        $this->formBuilder = new FormBuilder(
            $this->htmlBuilder,
            $this->urlGenerator,
            '',
            $this->translator
        );

        $month1 = $this->formBuilder->selectMonth('month');
        $month2 = $this->formBuilder->selectMonth('month', '1');
        $month3 = $this->formBuilder->selectMonth(
            'month',
            null,
            ['id' => 'foo']
        );
        $month4 = $this->formBuilder->selectMonth(
            'month',
            null,
            ['_prepend' => ['' => 'Choose a Month']]
        );

        $this->assertContains(
            '<select name="month"><option value="1">January</option>' .
            '<option value="2">February</option>',
            $month1
        );
        $this->assertContains(
            '<select name="month"><option value="1" selected="selected">' .
            'January</option>',
            $month2
        );
        $this->assertContains(
            '<select id="foo" name="month"><option value="1">January</option>',
            $month3
        );
        $this->assertContains(
            '<select name="month"><option value="" selected="selected">' .
            'Choose a Month</option><option value="1">January</option>',
            $month4
        );
    }

    /**
     * Test selectWeekday() method.
     */
    public function testFormSelectWeekday()
    {
        $this->translator
            ->shouldReceive('has')
            ->times(7*4)
            ->andReturn(false);
        
        $this->formBuilder = new FormBuilder(
            $this->htmlBuilder,
            $this->urlGenerator,
            '',
            $this->translator
        );

        $weekday1 = $this->formBuilder->selectWeekday('weekday');
        $weekday2 = $this->formBuilder->selectWeekday('weekday', '1');
        $weekday3 = $this->formBuilder->selectWeekday(
            'weekday',
            null,
            ['id' => 'foo']
        );
        $weekday4 = $this->formBuilder->selectWeekday(
            'weekday',
            null,
            ['_prepend' => ['' => 'Choose a Weekday']]
        );

        $this->assertContains(
            '<select name="weekday"><option value="1">Sunday</option>' .
            '<option value="2">Monday</option>',
            $weekday1
        );
        $this->assertContains(
            '<select name="weekday"><option value="1" selected="selected">' .
            'Sunday</option>',
            $weekday2
        );
        $this->assertContains(
            '<select id="foo" name="weekday"><option value="1">' .
            'Sunday</option>',
            $weekday3
        );
        $this->assertContains(
            '<select name="weekday"><option value="" selected="selected">' .
            'Choose a Weekday</option><option value="1">Sunday</option>',
            $weekday4
        );
    }

    /**
     * Test selectMonth() and SelectWeekday() translations.
     */
    public function testFormSelectTranslations()
    {
        $this->translator
            ->shouldReceive('has')
            ->times(12+7)
            ->andReturn(true);

        $this->translator
            ->shouldReceive('trans')
            ->times(12+7)
            ->andReturn('foo');

        $this->formBuilder = new FormBuilder(
            $this->htmlBuilder,
            $this->urlGenerator,
            '',
            $this->translator
        );

        $month = $this->formBuilder->selectMonth('month');
        $weekday = $this->formBuilder->selectWeekday('weekday');

        $this->assertContains(
            '<select name="month"><option value="1">foo</option>' .
            '<option value="2">foo</option>',
            $month
        );
        $this->assertContains(
            '<select name="weekday"><option value="1">foo</option>' .
            '<option value="2">foo</option>',
            $weekday
        );
    }
}
