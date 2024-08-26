<?php

namespace Drupal\auto_alt\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Generate Alt Text for an image.
 */
class AltTextGenerator extends ControllerBase {

  /**
   * Returns a renderable array for a test page.
   *
   * return []
   */
  public function generate() {
    // Get the url to the image from the request.
    $image_url = \Drupal::request()->get('image');
    if (!$image_url) {
      throw new NotFoundHttpException();
    }
    $image_contents = file_get_contents($image_url);
    $encoded_image = base64_encode($image_contents);
    // Now send this to chat gpt / ai to generate alt text.

    $response = [
      "This is some alt text for an image.",
      "A new string for alt text",
      "Another string about alt text",
    ];
    $text_to_return = rand(0,2);
    $json_response = new JsonResponse();
    $json_response->headers->set('Content-Type', 'application/json');
    $json_response->setData($response[$text_to_return]);
    return $json_response;
  }

}
