<?php

namespace Drupal\city_data\Entity;

use Drupal\Core\Entity\ContentEntityBase;

/**
 * Defines the City Data entity.
 *
 * @ingroup city_data
 *
 * @ContentEntityType(
 *   id = "city_data",
 *   label = @Translation("City Data"),
 *   base_table = "city_data",
 *   entity_keys = {
 *     "id" = "city_data_id",
 *     "label" = "title",
 *     "uid" = "uid",
 *     "state" = "state",
 *     "loc" = "geofield",
 *     "pop" = "pop"
 *   },
 *  
 * )
 */
class CityData extends ContentEntityBase implements ContentEntityInterface {

   public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
   		 // Standard field, used as unique if primary index.
    $fields['city_data_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the CityData entity.'))
      ->setRequired(TRUE)
      ->setSetting('unsigned', TRUE);
      ->setSetting('max_length', 5)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'integer_textfield',
        'weight' => -10,
      ));

      //string
    $fields['state'] = BaseFieldDefinition::create('string')
      ->setLabel(t('State'))
      ->setDescription(t('State of City'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSetting('max_length', 2)
      ->setDefaultValueCallback('Drupal\city_data\Entity\CityData::getDefaultState')
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -10,
      ));


    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The username of the content author.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback('Drupal\city_data\Entity\CityData::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE);


    // Standard field, unique outside of the scope of the current project.
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the city.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -10,
        'settings' => array(
          'size' => 60,
        ),
      ));
     
     $fields['loc'] = BaseFieldDefinition::create('geofield')
      ->setLabel(t('Location'))
      ->setDescription(t('The Location of the city.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('geofield_latlon', array(
        'type' => 'geofield_latlon',
      ));

     $fields['pop'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('POP'))
      ->setDescription(t('POP City'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 5)
      ->setSetting('unsigned', TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'integer_textfield',
        'weight' => -10,
      ));
;

    return $fields;  
   }

   public static function getCurrentUserId() {
    return [\Drupal::currentUser()->id()];
   }	
   public static function getDefaultState() {
    return "MA";
   }	
  
}