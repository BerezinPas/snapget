document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("consultationForm");
  if (!form) return;

  const responseMessage = form.querySelector(".response-message");
  const submitButton = form.querySelector('button[type="submit"]');

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    // Показываем лоадер
    const originalButtonText = submitButton.textContent;
    submitButton.textContent = "Отправка...";
    submitButton.disabled = true;
    responseMessage.style.display = "none";

    try {
      const formData = new FormData(form);

      // Добавляем honeypot поле для защиты от спама
      formData.append("website", "");

      const response = await fetch(consultationData.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          action: "send_consultation_request",
          ...Object.fromEntries(formData),
        }),
      });

      const result = await response.json();

      if (result.success) {
        responseMessage.textContent = result.data;
        responseMessage.style.color = "green";
        form.reset(); // Очищаем форму после успешной отправки
      } else {
        responseMessage.textContent =
          result.data || consultationData.errorMessage;
        responseMessage.style.color = "red";
      }
    } catch (error) {
      responseMessage.textContent = consultationData.errorMessage;
      responseMessage.style.color = "red";
      console.error("Ошибка:", error);
    } finally {
      responseMessage.style.display = "block";
      submitButton.textContent = originalButtonText;
      submitButton.disabled = false;
    }
  });
});
