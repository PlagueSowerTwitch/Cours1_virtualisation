package com.ingnum.rentalservice.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.client.RestTemplate;
import java.util.HashMap;
import java.util.Map;

@RestController
public class BonjourController {

    @Autowired
    private RestTemplate restTemplate;

    @GetMapping("/bonjour")
    public String bonjour() {
        return "bonjour";
    }

    @GetMapping("/greeting")
    public Map<String, Object> greeting(@RequestParam(defaultValue = "Guest") String name) {
        Map<String, Object> response = new HashMap<>();
        response.put("service", "RentalService");
        response.put("message", "Bonjour, " + name + " !");
        
        try {
            // Appel au SurnameService
            String surnameServiceUrl = "http://surname-service";
            Map<String, Object> surnameResponse = restTemplate.getForObject(
                surnameServiceUrl + "/?name=" + name, 
                Map.class
            );
            response.put("surnameService", surnameResponse);
        } catch (Exception e) {
            response.put("surnameService", "Service unavailable: " + e.getMessage());
        }
        
        return response;
    }
}
