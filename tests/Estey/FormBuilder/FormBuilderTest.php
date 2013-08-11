<?php

use Mockery as m;
use Estey\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;


class FormBuilderTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$this->urlGenerator = new UrlGenerator(new RouteCollection, Request::create('/foo', 'GET'));
		$this->htmlBuilder = new HtmlBuilder($this->urlGenerator);
		$this->translator = m::mock('Illuminate\Translation\Translator');
		$this->formBuilder =  new FormBuilder($this->htmlBuilder, $this->urlGenerator, '', $this->translator);
	}

	/**
	 * Destroy the test environment.
	 */
	public function tearDown()
	{
		m::close();
	}

	public function testSelect()
	{
		$select = $this->formBuilder->select(
			'size',
			array('L' => 'Large', 'S' => 'Small')
		);
		$this->assertEquals($select, '<select name="size"><option value="L">Large</option><option value="S">Small</option></select>');


		$select = $this->formBuilder->select(
			'size',
			 array('L' => 'Large', 'S' => 'Small'),
			 'L'
		);
		$this->assertEquals($select, '<select name="size"><option value="L" selected="selected">Large</option><option value="S">Small</option></select>');


		$select = $this->formBuilder->select(
			'size',
			array('L' => 'Large', 'S' => 'Small'),
			null,
			array('class' => 'class-name', 'id' => 'select-id')
		);
		$this->assertEquals($select, '<select class="class-name" id="select-id" name="size"><option value="L">Large</option><option value="S">Small</option></select>');

		$select = $this->formBuilder->select(
			'size',
			array('L' => 'Large', 'S' => 'Small'),
			null,
			array('class' => 'class-name', 'id' => 'select-id', '_prepend' => array('', 'Choose a Size'))
		);
		$this->assertEquals($select, '<select class="class-name" id="select-id" name="size"><option value="">Choose a Size</option><option value="L">Large</option><option value="S">Small</option></select>');		
	}

	public function testFormSelectMonth()
	{
		$month1 = $this->formBuilder->selectMonth('month');
		$month2 = $this->formBuilder->selectMonth('month', '1');
		$month3 = $this->formBuilder->selectMonth('month', null, array('id' => 'foo'));
		$month4 = $this->formBuilder->selectMonth('month', null, array('_prepend' => array('' => 'Choose a Month')));

		$this->assertContains('<select name="month"><option value="1">January</option><option value="2">February</option>', $month1);
		$this->assertContains('<select name="month"><option value="1" selected="selected">January</option>', $month2);
		$this->assertContains('<select id="foo" name="month"><option value="1">January</option>', $month3);
		$this->assertContains('<select name="month"><option value="" selected="selected">Choose a Month</option><option value="1">January</option>', $month4);
	}

	public function testFormSelectMonthTranslations()
	{
		$this->translator->shouldReceive('trans')->times(24)->andReturn('foo');
		$this->formbuilder = new FormBuilder($this->htmlBuilder, $this->urlGenerator, '', $this->translator);
		
		$months = $this->formbuilder->selectMonth('month');
		
		$this->assertContains('<select name="month"><option value="1">foo</option><option value="2">foo</option>', $months);		
	}

	public function testFormSelectWeekdayTranslations()
	{
		$this->translator->shouldReceive('trans')->times(24)->andReturn('foo');
		$this->formbuilder = new FormBuilder($this->htmlBuilder, $this->urlGenerator, '', $this->translator);
		
		$weekdays = $this->formbuilder->selectWeekday('day');
		
		$this->assertContains('<select name="day"><option value="1">foo</option><option value="2">foo</option>', $weekdays);		
	}	
}
