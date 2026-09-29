<?php

namespace App\Http\Requests\Concerns;

use App\Models\Plan;
use Illuminate\Validation\Rule;

trait ValidatesClientPlan
{
    /**
     * Normaliza el dominio propio: "https://www.MiTienda.com/" → "mitienda.com"
     */
    protected function normalizeCustomDomain(): void
    {
        if (!$this->filled('custom_domain')) {
            $this->merge(['custom_domain' => null]);

            return;
        }

        $domain = strtolower(trim($this->input('custom_domain')));
        $domain = preg_replace('#^https?://#', '', $domain);
        $domain = preg_replace('#^www\.#', '', $domain);
        $domain = rtrim(explode('/', $domain)[0], '.');

        $this->merge(['custom_domain' => $domain]);
    }

    protected function planRules($ignoreClient = null): array
    {
        return [
            'plan_id' => ['nullable', Rule::exists('plans', 'id')],
            'custom_domain' => [
                'nullable',
                'string',
                'max:253',
                'regex:/^(?!-)[a-z0-9-]{1,63}(?<!-)(\.(?!-)[a-z0-9-]{1,63}(?<!-))+$/',
                'not_regex:/(^|\.)quickweb\.com\.co$/',
                Rule::unique('clients', 'custom_domain')->ignore($ignoreClient),
                function ($attribute, $value, $fail) {
                    $plan = $this->filled('plan_id') ? Plan::find($this->input('plan_id')) : null;

                    if ($value && !$plan?->allows_custom_domain) {
                        $fail('El plan seleccionado no incluye dominio propio.');
                    }
                },
            ],
        ];
    }

    protected function planMessages(): array
    {
        return [
            'custom_domain.regex' => 'Escribe un dominio válido, por ejemplo: mitienda.com',
            'custom_domain.not_regex' => 'Los subdominios de quickweb.com.co se configuran en el campo "Dominio"',
            'custom_domain.unique' => 'Ese dominio ya está asignado a otra tienda',
        ];
    }
}
