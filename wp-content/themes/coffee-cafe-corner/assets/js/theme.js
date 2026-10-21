/**
 * Coffee Cafe Corner Theme - Main JavaScript
 * Handles theme interactive functionality
 */

// Faq
document.addEventListener("DOMContentLoaded", function () {
  const coffee_cafe_corner_game_details = document.querySelectorAll(".faq-btm-title");

  coffee_cafe_corner_game_details.forEach((targetDetail) => {
    targetDetail.addEventListener("toggle", () => {
      if (targetDetail.open) {
        coffee_cafe_corner_game_details.forEach((coffee_cafe_corner_game_detail) => {
          if (coffee_cafe_corner_game_detail !== targetDetail) {
            coffee_cafe_corner_game_detail.removeAttribute("open");
          }
        });
      }
    });
  });
});